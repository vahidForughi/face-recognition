<?php

namespace App\Orchid\Screens\Exams;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\ExamStoreRequest;
use App\Models\Exam;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Morilog\Jalali\Jalalian;
use Orchid\Support\Facades\Toast;

class ExamListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            "exams" => Exam::filters()->defaultSort('id')->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Exams List';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Add Exam')
                ->modal('examModal')
                ->method('create')
                ->icon('plus'),
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
            Layout::table('exams', [
                TD::make('Id')
                    ->sort()
                    ->render(function (Exam $exam) {
                        return $exam->id;
                    }),

                TD::make('title')
                    ->render(fn (Exam $exam) => Link::make($exam->title)->route('platform.systems.exams', $exam))
                    ->sort(),
                TD::make('slug')->sort(),


                TD::make('created_at', __('Created'))
//                    ->usingComponent(DateTimeSplit::class)
                    ->align(TD::ALIGN_RIGHT)
                    ->render(function (Exam $exam) {
                        return Jalalian::fromDateTime($exam->created_at);
                    })
                    ->sort(),

                TD::make('updated_at', __('Last edit'))
                    ->usingComponent(DateTimeSplit::class)
                    ->align(TD::ALIGN_RIGHT)
                    ->defaultHidden()
                    ->sort(),

                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Exam $exam) => DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([

                            Link::make(__('Show'))
                                ->route('platform.systems.exams.show', $exam->id)
                                ->icon('bs.eye'),

                            Link::make(__('Edit'))
                                ->route('platform.systems.exams.edit', $exam->id)
                                ->icon('bs.pencil'),

                            Button::make(__('Delete'))
                                ->icon('bs.trash3')
                                ->confirm(__('Once the exam is deleted, all of its resources and data will be permanently deleted.'))
                                ->method('remove', [
                                    'exam' => $exam->id,
                                ]),
                        ])),
            ]),

            Layout::modal('examModal', Layout::rows([
                Input::make('exam.title')->title('Title'),
                Input::make('exam.slug')->title('Slug'),

            ]))->title('Create Exam')
               ->async('asyncFind')
               ->applyButton('Save'),
        ];
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function create(ExamStoreRequest $request, Exam $exam)
    {
        $exam->store($request);

        Alert::info('You have successfully save a exam.');
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return Contact
     */
    public function asyncFind(Exam $exam = null): array
    {
        return [
            'exam' => $exam
        ];
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

}
