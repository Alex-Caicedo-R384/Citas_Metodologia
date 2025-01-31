<?php

namespace App\Repositories;

use App\Models\Profile;

class ProfileRepository
{
    public function createProfile($validatedData, $userId)
    {
        $profile = new Profile($validatedData);
        $profile->user_id = $userId;
        $profile->save();
        return $profile;
    }

    public function updateProfile($validatedData, $user)
    {
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);

        return $user->profile->update([
            'birth_date' => $validatedData['birth_date'],
            'gender' => $validatedData['gender'],
            'location' => $validatedData['location'],
            'bio' => $validatedData['bio'],
        ]);
    }

    public function deleteProfile($user)
    {
        $user->profile()->delete();
        $user->delete();
    }
}
