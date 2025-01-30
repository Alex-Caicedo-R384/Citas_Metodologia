<?php

namespace App\Factories;

use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class TwoUserChatFactory implements ChatFactoryInterface
{
    public function createChat($userId): Chat
    {
        return Chat::where(function($query) use ($userId) {
            $query->where('user_id_1', Auth::id())
                  ->where('user_id_2', $userId);
        })->orWhere(function($query) use ($userId) {
            $query->where('user_id_1', $userId)
                  ->where('user_id_2', Auth::id());
        })->first() ?? Chat::create([
            'user_id_1' => Auth::id(),
            'user_id_2' => $userId,
        ]);
    }
}
