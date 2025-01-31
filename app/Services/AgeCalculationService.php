<?php

namespace App\Services;

use Carbon\Carbon;

class AgeCalculationService
{
    public function calculate($user)
    {
        if ($user->profile && $user->profile->birth_date) {
            return Carbon::parse($user->profile->birth_date)->age;
        }

        return null;
    }
}
