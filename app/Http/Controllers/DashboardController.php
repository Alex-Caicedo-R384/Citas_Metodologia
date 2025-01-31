<?php

namespace App\Http\Controllers;

use App\Services\UserFilterService;
use App\Services\AgeCalculationService;
use App\Services\AppointmentService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $userFilterService;
    protected $ageCalculationService;
    protected $appointmentService;

    public function __construct(
        UserFilterService $userFilterService,
        AgeCalculationService $ageCalculationService,
        AppointmentService $appointmentService
    ) {
        $this->userFilterService = $userFilterService;
        $this->ageCalculationService = $ageCalculationService;
        $this->appointmentService = $appointmentService;
    }

    public function index(Request $request)
    {
        $users = $this->userFilterService->filter($request);

        foreach ($users as $user) {
            $user->age = $this->ageCalculationService->calculate($user);
        }

        $appointments = $this->appointmentService->getAppointments();

        $noFiltersApplied = !($request->has('gender') || $request->has('bio') || $request->has('location'));

        return view('dashboard', compact('users', 'noFiltersApplied', 'appointments'));
    }
}
