<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CounselorAppointmentController extends Controller
{
    public function index()
    {
        $counselor = Auth::guard('counselor')->user();

        $appointments = Appointment::with(['user', 'appointmentSession'])
            ->where('counselor_id', $counselor->id)
            ->orderByDesc('session_date')
            ->orderByDesc('session_time')
            ->paginate(15);

        return view('counselor.appointments.index', compact('appointments'));
    }

    public function today()
    {
        $counselor = Auth::guard('counselor')->user();
        $today = Carbon::today()->toDateString();

        $appointments = Appointment::with(['user', 'appointmentSession'])
            ->where('counselor_id', $counselor->id)
            ->whereDate('session_date', $today)
            ->orderBy('session_time')
            ->get();

        return view('counselor.appointments.today', compact('appointments'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $counselor = Auth::guard('counselor')->user();

        abort_unless($appointment->counselor_id === $counselor->id, 403);

        $data = $request->validate([
            'status' => ['required', 'in:pending,confirmed,completed,cancelled'],
        ]);

        $appointment->update($data);

        return back()->with('success', 'Appointment status updated.');
    }
}
