<?php

namespace App\Repositories;

use App\Contracts\ProfileCreatable;
use App\Contracts\ProfileUpdatable;
use App\Contracts\ProfileDeletable;
use App\Models\Profile;

class ProfileRepository implements ProfileCreatable, ProfileUpdatable, ProfileDeletable
{
    public function createProfile(array $data)
    {
        return Profile::create($data);
    }

    public function updateProfile(int $id, array $data)
    {
        $profile = Profile::findOrFail($id);
        $profile->update($data);
        return $profile;
    }

    public function deleteProfile(int $id)
    {
        return Profile::destroy($id);
    }
}
