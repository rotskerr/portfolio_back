<?php

namespace App\Orchid\Screens\Projects;

use App\Http\Requests\DesktopRequest;
use App\Http\Requests\ProjectsRequest;
use App\Models\Desktop;
use App\Models\Projects;
use App\Orchid\Layouts\Desktop\CreateOrUpdateDesktop;
use App\Orchid\Layouts\Desktop\DesktopTable;
use App\Orchid\Layouts\Projects\CreateOrUpdateProjects;
use App\Orchid\Layouts\Projects\ProjectsTable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProjectsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'projects' => Projects::paginate(5),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'перелік проектів';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Створити')->modal('create')->method('createOrUpdateProjects'),

        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [ProjectsTable::class,
            Layout::modal('create', CreateOrUpdateProjects::class)->title('Створення')->applyButton('Створити'),
            Layout::modal('edit', CreateOrUpdateProjects::class)->title('Редагування')->applyButton('Зберегти')->async('asyncGet'),
            Layout::modal('delete', Layout::rows([
                Input::make('project.id')->type('hidden'),
                Input::make('project.name')->readonly(),
                Input::make('project.URL')->readonly(),
                Picture::make('project.path')->title('картинка проекту'),
                TextArea::make('project.text')->readonly(),
            ]))->title('Видалення')->applyButton('Видалити')->async('asyncGet')];
    }
    public function asyncGet(Projects $project): array
    {
        return [
            'project' => $project,
        ];
    }

    public function createOrUpdateProjects(ProjectsRequest $request): void
    {
        $projectId = $request->input('project.id');

        $data = $request->input();
        if (is_null($projectId)) {
            $project = new Projects();
        } else {
            $project = Projects::where('id', $projectId)->first();
        }
        $project->name = $data['project']['name'];
        $project->path = $data['project']['path'];
        $project->text = $data['project']['text'];
        $project->URL = $data['project']['URL'];
        $project->save();

        $project->update($data);

        is_null($projectId) ? Toast::info('Здобуток успішно створений') : Toast::info(
            'Здобуток успішно відредагований'
        );
    }

    public function deleteProjects(ProjectsRequest $request)
    {
        $projectId = $request->input('project.id');
        $project = Projects::find($projectId);
        $project->delete();
        Toast::info('Запис успішно видалено');

    }
}

