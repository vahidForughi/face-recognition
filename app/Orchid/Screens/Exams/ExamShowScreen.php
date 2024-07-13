<?php

namespace App\Orchid\Screens\Exams;

use App\Http\Requests\ExamRequest;
use App\Models\Exam;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Morilog\Jalali\Jalalian;
use Orchid\Support\Facades\Toast;

class ExamShowScreen extends Screen
{
    /**
     * @var Exam
     */
    public $exam;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Exam $exam): iterable
    {
        $exam->load(['questions']);

        return [
            "exam" => $exam
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Show Exam';
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

            Link::make(__('Edit'))
                ->icon('bs.pencil')
                ->route('platform.systems.exams.edit', $this->exam->id),

            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__(' After this action exam will be permanently deleted. Are you sure ?'))
                ->method('remove')
                ->canSee($this->exam->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        $thumbnail = $this->exam->thumbnail ?: "/assets/exam-thumbnail.webp";
        return [
            Layout::legend('exam', [
                Sight::make('id')->popover('Unique number in the system'),
                Sight::make('title')->render(fn() => $this->exam->title),
                Sight::make('slug')->render(fn() => $this->exam->slug),
                Sight::make('thumbnail')->render(fn(Exam $exam) =>
                    "<img src={$thumbnail} alt='thumbnail' class='rounded-2' width='300px'>"
                ),
                Sight::make('description')->render(fn() => $this->exam->description),
                Sight::make('notice')->render(fn() => $this->exam->notice),
                Sight::make('questions count')->render(fn() => $this->exam->questions()->count()),
                Sight::make('participants count')->render(fn() => $this->exam->participants()->count()),
                Sight::make('created_at')->render(fn() => Jalalian::fromDateTime($this->exam->created_at)),
                Sight::make('updated_at')->render(fn() => Jalalian::fromDateTime($this->exam->updated_at)),
            ]),
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
