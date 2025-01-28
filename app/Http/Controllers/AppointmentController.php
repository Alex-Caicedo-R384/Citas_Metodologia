<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'partner_id' => ['required', 'exists:users,id'],
            'date' => ['required', 'date'],
        ]);

        $appointment = Appointment::create([
            'user_id' => auth()->id(),
            'partner_id' => $validated['partner_id'],
            'date' => $validated['date'],
        ]);

        return back()->with('status', 'Appointment successfully scheduled!');
    }

    public function destroy(Appointment $appointment)
    {
        // Eliminar la cita sin verificar el propietario
        $appointment->delete();
    
        return back()->with('status', 'Appointment successfully deleted!');
    }
    
}
