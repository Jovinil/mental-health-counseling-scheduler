<?php

namespace App\Http\Controllers;

use App\Models\Counselor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CounselorAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login', ['role' => 'counselor']);
    }

     public function showRegistrationForm()
    {
        // Same view, but counselor tab active
        return view('auth.register', ['role' => 'counselor']);
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'                => ['required', 'string', 'max:255'],
            'email'               => ['required', 'email', 'max:255', 'unique:counselors,email'],
            'password'            => ['required', 'confirmed', 'min:8'],
            'occupation'          => ['nullable', 'string', 'max:255'],
            'specialties'         => ['nullable', 'string', 'max:255'],
            'years_of_experience' => ['nullable', 'integer', 'min:0', 'max:80'],
            'languages'           => ['nullable', 'string', 'max:255'],
            'description'         => ['nullable', 'string', 'max:1000'],
        ]);

        $counselor = Counselor::create([
            'name'                => $data['name'],
            'email'               => $data['email'],
            'password'            => Hash::make($data['password']),
            'occupation'          => $data['occupation'] ?? null,
            'specialties'         => $data['specialties'] ?? null,
            'years_of_experience' => $data['years_of_experience'] ?? null,
            'languages'           => $data['languages'] ?? null,
            'description'         => $data['description'] ?? null,
        ]);

        Auth::guard('counselor')->login($counselor);

        return redirect()->intended('/counselor')
            ->with('success', 'Your counselor account has been created.');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

       if (Auth::guard('counselor')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/counselor');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('counselor')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
