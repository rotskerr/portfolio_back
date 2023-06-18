<?php

namespace App\Orchid\Layouts\Projects;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Layouts\Rows;

class CreateOrUpdateProjects extends Rows
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
            Input::make('project.id')->type('hidden'),
            Picture::make('project.path')->title('Демо картинка проекту')
                ->storage(
                    'images'
                )->acceptedFiles(
                    'image/*'
                ),
            Input::make('project.name')->required()->title('назва'),

            Input::make('project.text')->required()->title('текст'),
            Input::make('project.URL')->required()->title('посилання (нахуй)'),

        ];
    }
}
