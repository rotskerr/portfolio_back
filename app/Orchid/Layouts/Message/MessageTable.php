<?php

namespace App\Orchid\Layouts\Message;

use App\Models\Desktop;
use App\Models\Message;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class MessageTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'messages';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('text', 'Опис')->cantHide(),
            TD::make('email', 'email')->cantHide(),
            TD::make('created_at', 'Дата створення')->defaultHidden(),
            TD::make('updated_at', 'Дата оновлення (редагування)')->defaultHidden(),
            TD::make('action','')->render(function (Message $message) {
                return ModalToggle::make('Редагувати')
                    ->modal('edit')
                    ->method('createOrUpdateMessage')
                    ->asyncParameters([
                        'message' => $message->id
                    ]);
            })->alignRight()->cantHide(),
            TD::make('delete','')->render( function (Message $messages){
                return  ModalToggle::make('Видалити')
                    ->modal('delete')
                    ->method('deleteMessage')
                    ->asyncParameters([
                        'message' => $messages->id
                    ]);
            })->alignRight()->cantHide()->width(100),];
    }
}
