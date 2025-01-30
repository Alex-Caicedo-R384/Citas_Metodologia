<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Commands\SendMessageCommand;
use App\Factories\ChatFactoryInterface;


class ChatController extends Controller
{
    protected $chatFactory;

    public function __construct(ChatFactoryInterface $chatFactory)
    {
        $this->chatFactory = $chatFactory;
    }

    public function createChat($userId)
    {
        // Usar la fábrica para crear un chat
        $chat = $this->chatFactory->createChat($userId);

        return redirect()->route('chat.show', $chat->id);
    }

    public function showChat($chatId)
    {
        // Cargar el chat y las relaciones de los usuarios
        $chat = Chat::with(['user1', 'user2'])->findOrFail($chatId);

        // Obtener los mensajes del chat
        $messages = $chat->messages()->latest()->get();

        // Pasar el chat y los mensajes a la vista
        return view('chat.show', compact('chat', 'messages'));
    }

    public function sendMessage(Request $request, $chatId)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // Crear y ejecutar el comando para enviar el mensaje
        $command = new SendMessageCommand($chatId, $request->message);
        $command->execute();

        return back();
    }
}
