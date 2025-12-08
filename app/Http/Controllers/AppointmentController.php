<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Counselor;
use App\Models\AppointmentSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $view = $request->query('view', 'upcoming');
        $now = Carbon::now()->toDateString();

        $appointmentsQuery = Appointment::with(['counselor', 'appointmentSession'])
            ->where('user_id', Auth::id());

        if ($view === 'past') {
            $appointmentsQuery->whereDate('session_date', '<', $now)
                ->orderByDesc('session_date')
                ->orderByDesc('session_time');
        } elseif ($view === 'all') {
            $appointmentsQuery->orderByDesc('session_date')
                ->orderByDesc('session_time');
        } else { // upcoming (default)
            $appointmentsQuery->whereDate('session_date', '>=', $now)
                ->orderBy('session_date')
                ->orderBy('session_time');
        }

        $appointments = $appointmentsQuery->paginate(10)->withQueryString();

        return view('user.appointments.index', compact('appointments', 'view'));
    }

    public function create()
    {
        $counselors = Counselor::all();
        $sessions = AppointmentSession::all();

        return view('user.appointments.create', compact('counselors', 'sessions'));
    }

    public function store(Request $request)
    {
        $types = ['individual_counseling', 'couples_counseling', 'family_counseling', 'group_therapy'];

        $data = $request->validate([
            'counselor_id'           => ['required', 'exists:counselors,id'],
            'appointment_session_id' => ['required', 'exists:appointment_sessions,id'],
            'appointment_type'       => ['nullable', Rule::in($types)],
            'session_date'           => ['required', 'date'],
            // if you want, you can also validate the format:
            // 'session_time'           => ['required', 'date_format:"h:i A"'],
            'session_time'           => ['required'],
            'notes'                  => ['nullable', 'string', 'max:1000'],
            'phone'                  => ['nullable', 'string', 'max:30'],
        ]);

        // Convert "09:00 AM" -> "09:00:00" or "09:00-12:00 AM" -> "09:00:00"
        if (!empty($data['session_time'])) {
            $raw = $data['session_time'];

            // Handle ranges like "09:00-12:00 AM"
            if (preg_match('/^(\\d{1,2}:\\d{2})\\s*-\\s*(\\d{1,2}:\\d{2}\\s*[AP]M)$/i', $raw, $m)) {
                $start = $m[1];
                $meridiem = preg_match('/(AM|PM)/i', $m[2], $mm) ? $mm[1] : 'AM';
                $raw = trim($start . ' ' . $meridiem);
            }

            $data['session_time'] = Carbon::parse($raw)->format('H:i:s');
        }

        $data['user_id'] = Auth::id();
        $data['status']  = 'pending';

        Appointment::create($data);

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Your session has been booked. We will notify you once it is confirmed.');
    }

    public function show(Appointment $appointment)
    {
        abort_unless($appointment->user_id === Auth::id(), 403);

        $appointment->load(['counselor', 'appointmentSession']);

        return view('user.appointments.show', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        abort_unless($appointment->user_id === Auth::id(), 403);

        $data = $request->validate([
            'session_date' => ['required', 'date'],
            'session_time' => ['required'],
            'notes'        => ['nullable', 'string', 'max:1000'],
        ]);

        if (!empty($data['session_time'])) {
            // accept either "09:00" or "09:00 AM"
            $data['session_time'] = Carbon::parse($data['session_time'])->format('H:i:s');
        }

        $appointment->update($data + ['status' => 'pending']);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        abort_unless($appointment->user_id === Auth::id(), 403);

        $appointment->update(['status' => 'cancelled']); // safer than delete

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment cancelled.');
    }
}
