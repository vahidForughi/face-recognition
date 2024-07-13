<?php

declare(strict_types=1);

namespace App\Orchid\Presenters;

use Illuminate\Support\Str;
use Laravel\Scout\Builder;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Contracts\Personable;
use Orchid\Screen\Contracts\Searchable;
use Orchid\Screen\Layouts\Modal;
use Orchid\Support\Presenter;

class ParticipantPresenter extends Presenter implements Personable, Searchable
{
    /**
     * Returns the label for this presenter, which is used in the UI to identify it.
     */
    public function label(): string
    {
        return 'Participant';
    }

    /**
     * Returns the title for this presenter, which is displayed in the UI as the main heading.
     */
    public function title(): string
    {
        return $this->entity->fullname;
    }

    /**
     * Returns the subtitle for this presenter, which provides additional context about the user.
     */
    public function subTitle(): string
    {
        $subTitle = '';
        $subTitle .= $this->entity->gender ? $this->entity->genderValue($this->entity->gender) . ' - ' : '';
        $subTitle .= $this->entity->city ? $this->entity->city . ' - ' : '';
        $subTitle .= $this->entity->mobile ? $this->entity->mobile : '';
        return $subTitle;
    }

    /**
     * Returns the URL for this presenter, which is used to link to the user's edit page.
     */
    public function url(): string
    {
//        return route('platform.systems.contacts.show', $this->entity);
        return "";
    }

    /**
     * Returns the URL for the user's Gravatar image, or a default image if one is not found.
     */
    public function image(): ?string
    {
        return "";
    }

    /**
     * Returns the number of models to return for a compact search result.
     * This method is used by the search functionality to display a list of matching results.
     */
    public function perSearchShow(): int
    {
        return 3;
    }

    /**
     * Returns a Laravel Scout builder object that can be used to search for matching users.
     * This method is used by the search functionality to retrieve a list of matching results.
     */
    public function searchQuery(string $query = null): Builder
    {
        return $this->entity->search($query);
    }
}
