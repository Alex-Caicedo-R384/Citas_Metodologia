<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Profile;


class RegisteredUserController extends Controller
{

        /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);
    
        // Crear el usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
    
        // Crear el perfil asociado al usuario
        $profile = new Profile([
            'user_id' => $user->id,
            'name' => $user->name, // Puedes personalizar el nombre del perfil aquí
            'birth_date' => now()->subYears(25)->toDateString(), // Fecha de nacimiento por defecto
            'gender' => 'otro', // Género predeterminado
            'location' => 'Desconocida', // Ubicación predeterminada
            'bio' => '', // Bio vacía por defecto
        ]);
    
        $profile->save();
    
        // Iniciar sesión automáticamente
        Auth::login($user);
    
        // Redirigir al usuario a la página de creación de perfil
        return redirect()->route('profile.create');
    }
    
}
