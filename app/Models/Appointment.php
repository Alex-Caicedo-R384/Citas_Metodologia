<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['user_id', 'partner_id', 'date'];

    public function user()
    {
        // Cambiar el namespace incorrecto
        return $this->belongsTo(User::class, 'user_id');
    }

    public function partner()
    {
        // Cambiar el namespace incorrecto
        return $this->belongsTo(User::class, 'partner_id');
    }
}
