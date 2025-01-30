<?php

namespace App\Factories;

use App\Models\Appointment;

class PersonalAppointmentFactory implements AppointmentFactoryInterface
{
    public function createAppointment(array $data): Appointment
    {
        return Appointment::create([
            'user_id' => $data['user_id'],
            'partner_id' => $data['partner_id'],
            'date' => $data['date'],
            'type' => 'personal',
        ]);
    }
}
