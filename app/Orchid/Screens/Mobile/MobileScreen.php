<?php

namespace App\Orchid\Screens\Mobile;

use App\Http\Requests\DesktopRequest;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\MobileRequest;
use App\Models\Desktop;
use App\Models\Mobile;
use App\Orchid\Layouts\Desktop\CreateOrUpdateDesktop;
use App\Orchid\Layouts\Desktop\DesktopTable;
use App\Orchid\Layouts\Mobile\CreateOrUpdateMobile;
use App\Orchid\Layouts\Mobile\MobileTable;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class MobileScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'mobiles' => Mobile::paginate(5),

        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'MobileScreen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Створити')->modal('create')->method('createOrUpdateMobile'),

        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [MobileTable::class,
            Layout::modal('create', CreateOrUpdateMobile::class)->title('Створення')->applyButton('Створити'),
            Layout::modal('edit', CreateOrUpdateMobile::class)->title('Редагування')->applyButton('Зберегти')->async('asyncGet'),
            Layout::modal('delete', Layout::rows([
                Input::make('mobile.id')->type('hidden'),
                TextArea::make('mobile.text')->readonly(),
            ]))->title('Видалення')->applyButton('Видалити')->async('asyncGet')];
    }
    public function asyncGet(Mobile $mobile): array
    {
        return [
            'mobile' => $mobile,
        ];
    }

    public function createOrUpdateMobile(MobileRequest $request): void
    {
//        dd($request->input('book.number') );
        $mobileId = $request->input('mobile.id');

        $mobile = [
            'id' => $mobileId,
            'text' => $request->input('mobile.text'),
        ];

        Mobile::updateOrCreate([
            'id'=> $mobileId
        ], $mobile);

        is_null($mobileId) ? Toast::info('Запис успішно створено') : Toast::info('Запис успішно відредаговано');
    }

    public function deleteMobile(MobileRequest $request){
        $mobileId = $request->input('mobile.id');
        $mobile = Mobile::find($mobileId);
        $mobile->delete();
        Toast::info('Запис успішно видалено');
    }

}
