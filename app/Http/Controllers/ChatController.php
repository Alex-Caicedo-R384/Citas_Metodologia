<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function createChat($userId)
    {
        // Verificar si ya existe un chat entre los usuarios
        $chat = Chat::where(function($query) use ($userId) {
            $query->where('user_id_1', Auth::id())
                  ->where('user_id_2', $userId);
        })->orWhere(function($query) use ($userId) {
            $query->where('user_id_1', $userId)
                  ->where('user_id_2', Auth::id());
        })->first();

        // Si no existe, crea un nuevo chat
        if (!$chat) {
            $chat = Chat::create([
                'user_id_1' => Auth::id(),
                'user_id_2' => $userId,
            ]);
        }

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

        // Encontrar el chat por ID
        $chat = Chat::findOrFail($chatId);

        // Crear un nuevo mensaje
        $message = Message::create([
            'chat_id' => $chatId,
            'user_id' => Auth::id(),
            'content' => $request->message,
        ]);

        return back();
    }
}
