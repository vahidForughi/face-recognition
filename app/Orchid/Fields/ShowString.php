<?php

namespace App\Orchid\Fields;

use Orchid\Screen\Field;

class ShowString extends Field
{
    /**
     * Blade template
     *
     * @var string
     */
    protected $view = 'fields.showString';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [];
}
