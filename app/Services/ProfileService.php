<?php

namespace App\Services;

use App\Repositories\ProfileRepository;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    protected $profileRepository;

    // Inyectar el repositorio en el servicio
    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    // Método para crear un perfil
    public function createProfile($validatedData, $userId)
    {
        return $this->profileRepository->createProfile($validatedData, $userId);
    }

    // Método para actualizar un perfil
    public function updateProfile($validatedData, $user)
    {
        return $this->profileRepository->updateProfile($validatedData, $user);
    }

    // Método para eliminar un perfil
    public function deleteProfile($user)
    {
        $this->profileRepository->deleteProfile($user);
        Auth::logout(); // Desloguear al usuario después de eliminar su perfil
    }
}
