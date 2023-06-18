<?php

namespace App\Orchid\Layouts\Message;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class CreateOrUpdateMessage extends Rows
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
            Input::make('message.id')->type('hidden'),
            Input::make('message.email')->required()->type('email')->title('пошта користувача'),
            Input::make('message.text')->required()->title('повідомлення користувача'),

        ];
    }
}
