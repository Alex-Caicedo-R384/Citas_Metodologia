<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['user_id_1', 'user_id_2'];

    // Relación con los mensajes del chat
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Relación con el primer usuario del chat
    public function user1()
    {
        return $this->belongsTo(User::class, 'user_id_1');
    }

    // Relación con el segundo usuario del chat
    public function user2()
    {
        return $this->belongsTo(User::class, 'user_id_2');
    }
}
