<?php

namespace App\Contracts;

interface ProfileUpdatable
{
    public function updateProfile(int $id, array $data);
}
