<?php

namespace App\Http\Controllers;

use App\View\Dashboards\DashboardViewModelFactory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request, DashboardViewModelFactory $factory): View
    {
        return view('dashboard', [
            'dashboard' => $factory->make($request->user()),
        ]);
    }
}
