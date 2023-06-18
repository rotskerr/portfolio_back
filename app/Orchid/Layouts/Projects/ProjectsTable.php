<?php

namespace App\Orchid\Layouts\Projects;

use App\Models\Projects;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProjectsTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'projects';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('path', 'path')->cantHide()
                ->render(fn(Projects $project) =>
            "<img src='{$project->path}'
                              alt='sample'
                              class='mw-100 d-block img-fluid rounded-1 w-100'>
                            <span class='small text-muted mt-1 mb-0'># {$project->id}</span>"),
            TD::make('name', 'name')->cantHide(),
            TD::make('text', 'text')->cantHide(),
            TD::make('URL', 'URL')->cantHide(),
            TD::make('created_at', 'Дата створення')->defaultHidden(),
            TD::make('updated_at', 'Дата оновлення (редагування)')->defaultHidden(),
            TD::make('action','')->render(function (Projects $project) {
                return ModalToggle::make('Редагувати')
                    ->modal('edit')
                    ->method('createOrUpdateProjects')
                    ->asyncParameters([
                        'project' => $project->id
                    ]);
            })->alignRight()->cantHide(),
            TD::make('delete','')->render( function (Projects $project){
                return  ModalToggle::make('Видалити')
                    ->modal('delete')
                    ->method('deleteProjects')
                    ->asyncParameters([
                        'project' => $project->id
                    ]);
            })->alignRight()->cantHide()->width(100),];
    }
}
