<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Carbon\Carbon;

class CounselorDashboardController extends Controller
{
    public function index()
    {
        $counselor = Auth::guard('counselor')->user();

        $now = Carbon::now();
        $today = $now->toDateString();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        $todaySessions = Appointment::where('counselor_id', $counselor->id)
            ->whereDate('session_date', $today)
            ->count();

        $weekSessions = Appointment::where('counselor_id', $counselor->id)
            ->whereBetween('session_date', [$startOfWeek, $endOfWeek])
            ->count();

        $totalSessions = Appointment::where('counselor_id', $counselor->id)
            ->where('status', 'completed')
            ->count();

        $todayAppointments = Appointment::with(['user', 'appointmentSession'])
            ->where('counselor_id', $counselor->id)
            ->whereDate('session_date', $today)
            ->orderBy('session_time')
            ->get();

        return view('counselor.index', compact(
            'counselor',
            'todaySessions',
            'weekSessions',
            'totalSessions',
            'todayAppointments'
        ));
    }
}
