<?php

namespace App\Orchid\Layouts\Desktop;

use App\Models\Book;
use App\Models\Desktop;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DesktopTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'desktops';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('text', 'Опис')->cantHide(),
            TD::make('created_at', 'Дата створення')->defaultHidden(),
            TD::make('updated_at', 'Дата оновлення (редагування)')->defaultHidden(),
            TD::make('action','')->render(function (Desktop $desktop) {
                return ModalToggle::make('Редагувати')
                    ->modal('edit')
                    ->method('createOrUpdateDesktop')
                    ->asyncParameters([
                        'desktop' => $desktop->id
                    ]);
            })->alignRight()->cantHide(),
            TD::make('delete','')->render( function (Desktop $desktop){
                return  ModalToggle::make('Видалити')
                    ->modal('delete')
                    ->method('deleteDesktop')
                    ->asyncParameters([
                        'desktop' => $desktop->id
                    ]);
            })->alignRight()->cantHide()->width(100),
            ];
    }
}
