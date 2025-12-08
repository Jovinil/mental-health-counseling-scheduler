<?php

namespace App\Http\Controllers;

use App\Models\CounselorAvailability;
use App\Models\Counselor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CounselorAvailabilityController extends Controller
{
    public function index()
    {
        $counselor = Auth::guard('counselor')->user();

        $availabilities = CounselorAvailability::where('counselor_id', $counselor->id)
            ->orderBy('day_of_week')
            ->get();

        return view('counselor.availability.index', compact('availabilities'));
    }

    public function create()
    {
        return view('counselor.availability.create');
    }

    public function store(Request $request)
    {
        $counselor = Auth::guard('counselor')->user();

        $data = $request->validate([
            'day_of_week' => ['required', 'string'],  // ex: "Monday"
            'timeslot'    => ['required', 'array', 'min:1'],
            'timeslot.*'  => ['required', 'string'],  // ex: "09:00-12:00 AM"
        ]);

        $created = 0;

        foreach ($data['timeslot'] as $slot) {
            $slot = trim($slot);
            if ($slot === '') {
                continue;
            }

            CounselorAvailability::create([
                'counselor_id' => $counselor->id,
                'day_of_week'  => $data['day_of_week'],
                'timeslot'     => $slot,
            ]);
            $created++;
        }

        if ($created === 0) {
            return back()
                ->withErrors(['timeslot' => 'Please add at least one valid time range.'])
                ->withInput();
        }

        return redirect()
            ->route('counselor.availability.index')
            ->with('success', 'Availability added.');
    }

    public function destroy(CounselorAvailability $availability)
    {
        $counselor = Auth::guard('counselor')->user();

        abort_unless($availability->counselor_id === $counselor->id, 403);

        $availability->delete();

        return back()->with('success', 'Availability removed.');
    }

    /**
     * AJAX endpoint: /api/counselors/{counselor}/available-slots?date=YYYY-MM-DD
     */
   public function availableSlots(Request $request, $counselorId)
{
    $dateString = $request->query('date');

    if (!$dateString) {
        return response()->json([
            'message' => 'Missing date parameter.',
        ], 422);
    }

    $date = Carbon::parse($dateString);
    $dayOfWeek = $date->format('l'); // "Monday", etc.

    $slots = CounselorAvailability::where('counselor_id', $counselorId)
        ->where('day_of_week', $dayOfWeek)
        ->pluck('timeslot');

    return response()->json([
        'date'        => $date->toDateString(),
        'day_of_week' => $dayOfWeek,
        'slots'       => $slots,
    ]);
}

}
