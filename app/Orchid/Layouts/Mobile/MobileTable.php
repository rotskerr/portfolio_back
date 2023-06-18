<?php

namespace App\Orchid\Layouts\Mobile;

use App\Models\Desktop;
use App\Models\Mobile;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class MobileTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'mobiles';

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
            TD::make('action','')->render(function (Mobile $mobile) {
                return ModalToggle::make('Редагувати')
                    ->modal('edit')
                    ->method('createOrUpdateMobile')
                    ->asyncParameters([
                        'mobile' => $mobile->id
                    ]);
            })->alignRight()->cantHide(),
            TD::make('delete','')->render( function (Mobile $mobile){
                return  ModalToggle::make('Видалити')
                    ->modal('delete')
                    ->method('deleteMobile')
                    ->asyncParameters([
                        'mobile' => $mobile->id
                    ]);
            })->alignRight()->cantHide()->width(100),];
    }
}
