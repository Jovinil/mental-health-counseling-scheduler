<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Counselor;
use App\Models\Appointment;

class BookingsController extends Controller
{
    public function index(){
        $counselors = Counselor::select('name')->get();

        return view('user.book-sessions', compact('counselors'));
    }
}
