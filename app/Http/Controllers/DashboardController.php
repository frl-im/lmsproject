<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the user's dashboard.
     */
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $courses = Course::latest()->get();

        // Eager load a-relasi untuk efisiensi query
        $user->load('badges');

        return view('dashboard', [
            'user' => $user,
            'courses' => $courses,
            'badges' => $user->badges,
        ]);
    }
}
