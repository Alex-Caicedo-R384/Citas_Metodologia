<?php

namespace App\Commands;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class SendMessageCommand
{
    protected $chatId;
    protected $messageContent;

    public function __construct($chatId, $messageContent)
    {
        $this->chatId = $chatId;
        $this->messageContent = $messageContent;
    }

    public function execute()
    {
        $chat = Chat::findOrFail($this->chatId);

        return Message::create([
            'chat_id' => $this->chatId,
            'user_id' => Auth::id(),
            'content' => $this->messageContent,
        ]);
    }
}
