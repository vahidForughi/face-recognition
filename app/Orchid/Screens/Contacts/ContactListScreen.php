<?php

namespace App\Orchid\Screens\Contacts;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Platform\Models\User;
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

class ContactListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $authUser = request()->user();

        return [
            "contacts" => $authUser->inRole('admin')
                ? Contact::filters()->defaultSort('id')->paginate()
                : Contact::whereIn('landing_id', $authUser->landings?->pluck('id')->all())->filters()->defaultSort('id')->paginate()

        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Contacts List';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Add Contact')
                ->modal('contactModal')
                ->method('createOrUpdate')
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
            Layout::table('contacts', [
                TD::make('Id')
                    ->sort()
                    ->render(function (Contact $contact) {
                        return $contact->id;
                    }),

                TD::make('sender')->render(fn (Contact $contact) =>
                    new Persona($contact->presenter())
                ),

//                TD::make('sender_name')->sort(),
//                TD::make('sender_mobile')->sort(),
//                TD::make('sender_email')->sort()->defaultHidden(),

                TD::make('landing')
                    ->sort()
                    ->render(function (Contact $contact) {
                        return $contact->landing?->name;
                    }),

                TD::make('subject')
                    ->sort()
                    ->render(function (Contact $contact) {
                        return $contact->subjectValue();
                    }),

                TD::make('created_at', __('Created'))
//                    ->usingComponent(DateTimeSplit::class)
                    ->align(TD::ALIGN_RIGHT)
                    ->render(function (Contact $contact) {
                        return Jalalian::fromDateTime($contact->created_at);
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
                    ->render(fn (Contact $contact) => DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([

                            Link::make(__('Show'))
                                ->route('platform.systems.contacts.show', $contact->id)
                                ->icon('bs.eye'),

                            ModalToggle::make('Edit')
                                ->modal('contactModal')
                                ->method('createOrUpdate', [
                                    'id' => $contact->id,
                                ])
                                ->asyncParameters([
                                    'contact' => $contact->id
                                ])
                                ->icon('bs.pencil'),

                            Button::make(__('Delete'))
                                ->icon('bs.trash3')
                                ->confirm(__('Once the contact is deleted, all of its resources and data will be permanently deleted.'))
                                ->method('remove', [
                                    'contact' => $contact->id,
                                ]),
                        ])),
            ]),

            Layout::modal('contactModal', Layout::rows([
                Input::make('contact.sender_name')
                    ->title('Sender Name')
//                    ->placeholder('Enter contact sender name')
                ,

                Input::make('contact.sender_email')
                    ->title('Sender Email')
//                    ->placeholder('Enter contact sender email')
                ,

                Input::make('contact.sender_mobile')
                    ->title('Sender Mobile')
//                    ->placeholder('Enter contact sender mobile')
                ,

                Select::make('contact.subject')
                    ->options(['Lead' => 'Lead'])
                    ->title('Subject')
            ]))
            ->title('Create Contact')
            ->async('asyncFind')
            ->applyButton('Save'),
        ];
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function createOrUpdate(ContactRequest $request, Contact $contact)
    {
        $contact->store($request);

        Alert::info('You have successfully save a contact.');
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return Contact
     */
    public function asyncFind(Contact $contact = null): array
    {
        return [
            'contact' => $contact
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
