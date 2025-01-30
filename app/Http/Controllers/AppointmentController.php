<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Services\AppointmentService;
use Illuminate\Http\RedirectResponse;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function store(StoreAppointmentRequest $request): RedirectResponse
    {
        $this->appointmentService->createAppointment($request->validated());

        return back()->with('status', 'Appointment successfully scheduled!');
    }

    public function destroy(Appointment $appointment): RedirectResponse
    {
        $this->appointmentService->deleteAppointment($appointment);

        return back()->with('status', 'Appointment successfully deleted!');
    }
}
