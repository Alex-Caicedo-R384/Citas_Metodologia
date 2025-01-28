<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['user_id', 'partner_id', 'date'];

    public function user()
    {
        return $this->belongsTo(App\Models\User::class, 'user_id');
    }

    public function partner()
    {
        return $this->belongsTo(App\Models\User::class, 'partner_id');
    }
}

