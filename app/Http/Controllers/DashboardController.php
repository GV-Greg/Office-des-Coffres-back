<?php

namespace App\Http\Controllers;

use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:test', ['only' => 'test']);
    }

    public function index()
    {
        $players = User::where('is_validated', 0)->orderBy('id','ASC')->paginate(8);

        return view('dashboard', compact('players'));
    }

    public function test()
    {
        return view('dashboard');
    }
}
