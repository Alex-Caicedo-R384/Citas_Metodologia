<?php

namespace App\Factories;

use App\Models\Chat;

interface ChatFactoryInterface
{
    public function createChat($userId): Chat;
}
