<?php

namespace App\Http\Controllers;

use App\Models\AppointmentSession;
use Illuminate\Http\Request;

class AppointmentSessionController extends Controller
{
    public function index()
    {
        $sessions = AppointmentSession::paginate(10);

        return view('admin.sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('admin.sessions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'duration'    => ['required', 'integer', 'min:15'],
            'price'       => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        AppointmentSession::create($data);

        return redirect()
            ->route('admin.sessions.index')
            ->with('success', 'Session type created.');
    }

    public function edit(AppointmentSession $session)
    {
        return view('admin.sessions.edit', compact('session'));
    }

    public function update(Request $request, AppointmentSession $session)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'duration'    => ['required', 'integer', 'min:15'],
            'price'       => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        $session->update($data);

        return redirect()
            ->route('admin.sessions.index')
            ->with('success', 'Session type updated.');
    }

    public function destroy(AppointmentSession $session)
    {
        $session->delete();

        return redirect()
            ->route('admin.sessions.index')
            ->with('success', 'Session type deleted.');
    }
}
