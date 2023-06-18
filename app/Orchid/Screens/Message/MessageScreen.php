<?php

namespace App\Orchid\Screens\Message;

use App\Http\Requests\DesktopRequest;
use App\Http\Requests\MessageRequest;
use App\Models\Desktop;
use App\Models\Message;
use App\Orchid\Layouts\Desktop\CreateOrUpdateDesktop;
use App\Orchid\Layouts\Desktop\DesktopTable;
use App\Orchid\Layouts\Message\CreateOrUpdateMessage;
use App\Orchid\Layouts\Message\MessageTable;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class MessageScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'messages' => Message::paginate(5),

        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Повідомлення від користувача';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Створити')->modal('create')->method('createOrUpdateMessage'),

        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [MessageTable::class,
            Layout::modal('create', CreateOrUpdateMessage::class)->title('Створення')->applyButton('Створити'),
            Layout::modal('edit', CreateOrUpdateMessage::class)->title('Редагування')->applyButton('Зберегти')->async('asyncGet'),
            Layout::modal('delete', Layout::rows([
                Input::make('message.id')->type('hidden'),
                Input::make('message.email')->readonly(),
                TextArea::make('message.text')->readonly(),
            ]))->title('Видалення')->applyButton('Видалити')->async('asyncGet')];
    }
    public function asyncGet(Message $message): array
    {
        return [
            'message' => $message,
        ];
    }

    public function createOrUpdateMessage(MessageRequest $request): void
    {
//        dd($request->input('book.number') );
        $messageId = $request->input('message.id');

        $message = [
            'id' => $messageId,
            'text' => $request->input('message.text'),
            'email' => $request->input('message.email'),
        ];


        Message::updateOrCreate([
            'id'=> $messageId
        ], $message);

        is_null($messageId) ? Toast::info('Запис успішно створено') : Toast::info('Запис успішно відредаговано');
    }

    public function deleteMessage(MessageRequest $request){
        $messageId = $request->input('message.id');
        $message = Message::find($messageId);

        $message->delete();
        Toast::info('Запис успішно видалено');
    }
}
