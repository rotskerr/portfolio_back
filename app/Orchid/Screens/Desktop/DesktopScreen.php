<?php

namespace App\Orchid\Screens\Desktop;

use App\Http\Requests\DesktopRequest;
use App\Models\Desktop;
use App\Orchid\Layouts\Desktop\CreateOrUpdateDesktop;
use App\Orchid\Layouts\Desktop\DesktopTable;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DesktopScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'desktops' => Desktop::paginate(5),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Текст для десктопу';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Створити')->modal('create')->method('createOrUpdateDesktop'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [DesktopTable::class,
            Layout::modal('create', CreateOrUpdateDesktop::class)->title('Створення')->applyButton('Створити'),
            Layout::modal('edit', CreateOrUpdateDesktop::class)->title('Редагування')->applyButton('Зберегти')->async('asyncGet'),
            Layout::modal('delete', Layout::rows([
                Input::make('desktop.id')->type('hidden'),
                TextArea::make('desktop.text')->readonly(),
            ]))->title('Видалення')->applyButton('Видалити')->async('asyncGet')];
    }
    public function asyncGet(Desktop $desktop): array
    {
        return [
            'desktop' => $desktop,
        ];
    }

    public function createOrUpdateDesktop(DesktopRequest $request): void
    {
//        dd($request->input('book.number') );
        $desktopId = $request->input('desktop.id');

        $desktop = [
            'id' => $desktopId,
            'text' => $request->input('desktop.text'),
        ];

        Desktop::updateOrCreate([
            'id'=> $desktopId
        ], $desktop);

        is_null($desktopId) ? Toast::info('Запис успішно створено') : Toast::info('Запис успішно відредаговано');
    }

    public function deleteDesktop(DesktopRequest $request){
        $desktopId = $request->input('desktop.id');
        $desktop = Desktop::find($desktopId);
        $desktop->delete();
        Toast::info('Запис успішно видалено');
    }
}
