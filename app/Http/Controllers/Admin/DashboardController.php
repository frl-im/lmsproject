<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::where('is_admin', false)->count(),
            'courses' => Course::count(),
            'lessons' => Lesson::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}
