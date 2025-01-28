<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Agrega esta línea


class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'birth_date',
        'gender',
        'location',
        'bio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function show()
    {
        $profile = auth()->user()->profile; // Obtiene el perfil del usuario autenticado
        return view('profile.show', compact('profile'));
    }
}

