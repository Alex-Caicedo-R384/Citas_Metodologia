<?php

namespace App\Services;

use App\Models\Appointment;
use App\Repositories\AppointmentRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentService
{
    protected $appointmentRepository;

    public function __construct(AppointmentRepositoryInterface $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function createAppointment($validatedData)
    {
        return $this->appointmentRepository->create([
            'user_id' => Auth::id(),
            'partner_id' => $validatedData['partner_id'],
            'date' => $validatedData['date'],
        ]);
    }

    public function deleteAppointment(Appointment $appointment)
    {
        $this->appointmentRepository->delete($appointment);
    }

    public function getAppointments()
    {
        return Appointment::where('user_id', auth()->id())
            ->with('partner')
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'partner_name' => $appointment->partner->name,
                    'date' => Carbon::parse($appointment->date)->toDateString(),
                ];
            });
    }
}
