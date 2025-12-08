<?php

namespace App\Http\Controllers;

use App\Models\Counselor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // You can limit or order the counselors for the home page
        $counselors = Counselor::take(4)->get();

        return view('home.index', compact('counselors'));
    }

    public function counselors()
    {
        $counselors = Counselor::with('availabilities')->paginate(8);

        return view('home.counselors', compact('counselors'));
    }

    public function showCounselor(Counselor $counselor)
    {
        // Later: you can eager load availability or stats
        return view('home.counselors', compact('counselor'));
    }
}
