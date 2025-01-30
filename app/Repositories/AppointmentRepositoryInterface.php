<?php

namespace App\Repositories;

use App\Models\Appointment;

interface AppointmentRepositoryInterface
{
    public function create(array $data): Appointment;
    public function delete(Appointment $appointment): void;
}
