<?php

namespace App\Repositories;

use App\Models\Appointment;

class EloquentAppointmentRepository implements AppointmentRepositoryInterface
{
    public function create(array $data): Appointment
    {
        return Appointment::create($data);
    }

    public function delete(Appointment $appointment): void
    {
        $appointment->delete();
    }
}
