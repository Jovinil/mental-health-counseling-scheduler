<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $now = Carbon::now();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        $totalSessions = Appointment::where('user_id', $user->id)
            ->count();

        $completedSessions = Appointment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $thisMonthSessions = Appointment::where('user_id', $user->id)
            ->whereBetween('session_date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->where('status', '!=', 'cancelled')
            ->count();

        $upcomingAppointments = Appointment::with(['counselor', 'appointmentSession'])
            ->where('user_id', $user->id)
            ->whereDate('session_date', '>=', $now->toDateString())
            ->orderBy('session_date')
            ->orderBy('session_time')
            ->take(5)
            ->get();

        $pastAppointments = Appointment::with(['counselor', 'appointmentSession'])
            ->where('user_id', $user->id)
            ->whereDate('session_date', '<', $now->toDateString())
            ->orderByDesc('session_date')
            ->orderByDesc('session_time')
            ->take(5)
            ->get();

        // Simple streak: consecutive weeks (starting this week) with at least one completed session
        $completedWeeks = Appointment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderByDesc('session_date')
            ->pluck('session_date')
            ->map(fn ($date) => Carbon::parse($date)->startOfWeek()->toDateString())
            ->unique()
            ->values();

        $streakWeeks = 0;
        $cursor = $now->copy()->startOfWeek()->toDateString();
        while ($completedWeeks->contains($cursor)) {
            $streakWeeks++;
            $cursor = Carbon::parse($cursor)->subWeek()->toDateString();
        }

        $progressData = [
            'Overall Progress' => min(100, $completedSessions * 10),
            'Upcoming Prep' => min(100, $upcomingAppointments->count() * 15),
            'Streak (weeks)' => min(100, $streakWeeks * 12),
        ];

        return view('user.index', compact(
            'user',
            'totalSessions',
            'thisMonthSessions',
            'upcomingAppointments',
            'pastAppointments',
            'streakWeeks',
            'progressData'
        ));
    }
}
