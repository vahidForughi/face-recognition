<?php

namespace App\Orchid\Screens\Exams;

use App\Helpers\General\Utils;
use App\Http\Requests\ExamQuestionStoreRequest;
use App\Http\Requests\ExamRequest;
use App\Http\Requests\ExamStoreRequest;
use App\Models\Exam;
use App\Models\ExamParticipant;
use App\Models\ExamQuestion;
use App\Orchid\Fields\ShowString;
use Illuminate\Support\Arr;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Attach;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Fields\ViewField;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Morilog\Jalali\Jalalian;
use Orchid\Support\Facades\Toast;

class ExamEditScreen extends Screen
{
    /**
     * @var Exam
     */
    public $exam;

    /**
     * @var ExamParticipant
     */
    public $participantToShow;

    private $examResultColumns = ['condition', 'content'];
    private $questionScoreColumns = ['condition', 'amount'];

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Exam $exam): iterable
    {
        $exam->load(['questions']);
        if (isset($exam->results) && $exam->results) {
            $exam->matrixResults = Utils::arrayToMatrix($exam->results, $this->examResultColumns[1], $this->examResultColumns[0]);
        }

        return [
            "exam" => $exam,
            "participants" => $exam->participants()->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Edit Exam';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Exam List'))
                ->icon('bs.list-ul')
                ->route('platform.systems.exams'),

            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__(' After this action exam will be permanently deleted. Are you sure ?'))
                ->method('remove'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [

            Layout::tabs([
                'information' => Layout::rows([
                    Input::make('exam.title')->title('Title'),
                    Input::make('exam.slug')->title('Slug'),
                    Quill::make('exam.description')->title('Description'),
                    TextArea::make('exam.notice')->title('Notice'),
                    Picture::make('exam.thumbnail')->title('Thumbnail')->storage('local')->targetRelativeUrl(),
//                    Attach::make('thumbnail'),
//                    Upload::make('thumbnail')->media(),
                    Matrix::make('exam.matrixResults')->title('Results')->columns($this->examResultColumns),
                    Button::make('Save')->method('updateExam')
                ]),

                'questions' => [
                    Layout::rows([
                        ModalToggle::make('Add Question')
                            ->modal('questionModal')
                            ->method('createOrUpdateQuestion')
                            ->icon('plus'),
                    ]),

                    Layout::table('exam.questions', [
                        TD::make('Id')
                            ->sort()
                            ->render(function (ExamQuestion $question) {
                                return $question->id;
                            }),

                        TD::make('title')->sort(),

                        TD::make('type')->sort(),

                        TD::make('options')->render(function (ExamQuestion $question) {
                            return ExamQuestion::optionsToString($question->options);
                        }),

                        TD::make('scores')->render(function (ExamQuestion $question) {
                            return ExamQuestion::scoresToString($question->scores);
                        }),
//                        TD::make('scores')->render(function (ExamQuestion $question) {
//                            return ($question->scores);
//                            return ExamQuestion::scoresToString($question->scores);
//                        }),

                        TD::make(__('Actions'))
                            ->align(TD::ALIGN_CENTER)
                            ->width('100px')
                            ->render(fn (ExamQuestion $question) => DropDown::make()
                                ->icon('bs.three-dots-vertical')
                                ->list([

                                    ModalToggle::make('Edit Question')
                                        ->modal('questionModal')
                                        ->method('createOrUpdateQuestion', [
                                            'exam_id' => $this->exam->id,
                                            'question_id' => $question->id,
                                        ])
                                        ->asyncParameters([
                                            'question' => $question->id
                                        ])
                                        ->icon('bs.pencil'),

                                    Button::make(__('Delete'))
                                        ->icon('bs.trash3')
                                        ->confirm(__('Once the question is deleted, all of its resources and data will be permanently deleted.'))
                                        ->method('removeQuestion', [
                                            'question' => $question->id,
                                        ]),
                                ])),
                    ]),
                ],

                'participants' => [
                    Layout::table('participants', [
                        TD::make('id')->sort(),
                        // TD::make('sender')->render(fn (ExamParticipant $participant) =>
                        //     new Persona($participant->presenter())
                        // ),
                        TD::make('fullname')->sort(),
                        TD::make('mobile')->sort(),
                        TD::make('gender')->render(fn (ExamParticipant $participant) =>
                            $participant->genderValue()
                        )->sort(),
                        TD::make('city')->sort(),
                        TD::make('score')->sort(),
                        TD::make(__('Actions'))
                            ->align(TD::ALIGN_CENTER)
                            ->width('100px')
                            ->render(fn (ExamParticipant $participant) =>
                                    ModalToggle::make('Responses')
                                        ->modal('showParticipantModal')
                                        ->asyncParameters([
                                            'exam' => $this->exam->id,
                                            'participant' => $participant->id,
                                        ])
                                        ->icon('bs.eye')
                            )
                    ]),
                ]

            ]),


            Layout::modal('questionModal', Layout::rows([
                Input::make('question.title')->title('Title'),
                Select::make('question.type')->title('Type')->options(Utils::arrayToKeyValue(ExamQuestion::TYPES)),
                Matrix::make('question.matrixOptions')->title('Options')->columns(['value']),
                Matrix::make('question.matrixScores')->title('Scores')->columns($this->questionScoreColumns)
            ]))->title('Create Question')
                ->async('asyncFindQuestion')
                ->applyButton('Save'),


            Layout::modal('showParticipantModal',
                Layout::Table('responses', [
                    TD::make('id'),
                    TD::make('title'),
                    TD::make('response')->render(function($value) {
                        return is_array($value->response) ? implode(' | ', $value->response) : $value->response;
                    }),
                ])
            )->title('Participant Responses')
             ->async('asyncFindParticipant')
             ->size(Modal::SIZE_LG)
             ->withoutApplyButton(),
        ];
    }



    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function asyncFindQuestion(ExamQuestion $question = null): array
    {
        if (isset($question->options) && $question->options) {
            $question->matrixOptions = Utils::arrayToMatrix($question->options);
        }
        if (isset($question->scores) && $question->scores) {
            $question->matrixScores = Utils::arrayToMatrix($question->scores, $this->questionScoreColumns[1], $this->questionScoreColumns[0]);
        }
        return [
            'question' => $question
        ];
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function asyncFindParticipant(Exam $exam, ExamParticipant $participant): array
    {
        foreach ($exam->questions as $key=>$question) {
            $response = Arr::first($participant->responses, function ($value, $key) use ($question) {
                return $value['q_id'] == $question->id;
            });
            $response = $response ? $response['value'] : null;

            $exam->questions[$key]->response = $response;
        }
        return [
            'responses' => $exam->questions,
        ];
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function showParticipantBox(ExamParticipant $participant): void
    {
        $this->participantToShow = $participant;
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function updateExam(ExamStoreRequest $request, Exam $exam)
    {
        $inputExam = $request->exam;
        $inputExam['results'] = Utils::matrixToArray($request->input('exam.matrixResults'), $this->examResultColumns[1], $this->examResultColumns[0]);
        $request->merge(["exam" => $inputExam]);

        $exam->store($request);

        Alert::info('You have successfully save a exam.');
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function remove(Exam $exam)
    {
        $exam->delete();

        Toast::success(__('Exam was removed'));

        return redirect()->route('platform.systems.exams');
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function createOrUpdateQuestion(ExamQuestionStoreRequest $request, Exam $exam, ExamQuestion $question)
    {
        $request->merge(["exam_id" => $exam?->id]);
        $inputQuestion = $request->question;
        $inputQuestion['options'] = Utils::matrixToArray($request->input('question.matrixOptions'));
        $inputQuestion['scores'] = Utils::matrixToArray($request->input('question.matrixScores'), $this->questionScoreColumns[1], $this->questionScoreColumns[0]);
        $request->merge(["question" => $inputQuestion]);

        $question->store($request);

        Alert::info('You have successfully save a question.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function removeQuestion(ExamQuestion $question)
    {
        $question->delete();

        Toast::success(__('Question was removed'));
    }

}
