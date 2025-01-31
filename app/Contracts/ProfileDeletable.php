<?php

namespace App\Contracts;

interface ProfileDeletable
{
    public function deleteProfile(int $id);
}
