<?php

namespace App\Orchid\Layouts\Desktop;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class CreateOrUpdateDesktop extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('desktop.id')->type('hidden'),
            Input::make('desktop.text')->required(),
        ];
    }
}
