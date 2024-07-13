<?php

namespace App\Orchid\Screens\Contacts;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Morilog\Jalali\Jalalian;
use Orchid\Support\Facades\Toast;

class ContactShowScreen extends Screen
{
    /**
     * @var Contact
     */
    public $contact;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Contact $contact): iterable
    {
        $contact->load(['landing']);

        return [
            "contact" => $contact
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Show Contact';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Contact List'))
                ->icon('bs.list-ul')
                ->route('platform.systems.contacts'),

            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__(' After this action contact will be permanently deleted. Are you sure ?'))
                ->method('remove')
                ->canSee($this->contact->exists),
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
            Layout::legend('contact', [
                Sight::make('id')->popover('Unique number in the system'),
                Sight::make('sender image')->render(fn(Contact $contact) =>
                    "<img src=/storage/local/uploads/contact/{$contact->sender_image} alt='sender image' class='rounded-2'>"
                ),
                Sight::make('sender name')->render(fn() => $this->contact->sender_name),
                Sight::make('sender email')->render(fn() => $this->contact->sender_email),
                Sight::make('sender email')->render(fn() => $this->contact->sender_mobile),
                Sight::make('landing')->render(fn() => $this->contact->landing?->name),
                Sight::make('subject')->render(fn() => $this->contact->subjectValue()),
                Sight::make('created_at')->render(fn() => Jalalian::fromDateTime($this->contact->created_at)),
                Sight::make('updated_at')->render(fn() => Jalalian::fromDateTime($this->contact->updated_at)),
            ])
//            ->canSee(request()->user()->hasAccessTo())
            ,
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function remove(Contact $contact)
    {
        $contact->delete();

        Toast::success(__('Contact was removed'));

        return redirect()->route('platform.systems.contacts');
    }

}
