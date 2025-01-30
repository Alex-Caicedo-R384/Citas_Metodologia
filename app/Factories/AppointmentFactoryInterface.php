<?php

namespace App\Factories;

use App\Models\Appointment;

interface AppointmentFactoryInterface
{
    public function createAppointment(array $data): Appointment;
}
