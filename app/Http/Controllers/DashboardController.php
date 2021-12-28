<?php

namespace App\Http\Controllers;

use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $players = User::where('is_validated', 0)->orderBy('id','ASC')->paginate(8);

        return view('dashboard', compact('players'));
    }
}
