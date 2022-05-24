<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class AuthenticatedSessionController extends BaseController
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if($user) {
            if($user->hasRole('Admin')) {
                if($user->is_validated === true) {
                    $request->authenticate();
                } else {
                    Alert::error('Compte non validé', "Votre compte n'est pas validé.");
                    return back()->with('error', "Votre compte n'est pas validé.");
                }
            } else {
                Alert::error('Compte non autorisé', "Vous n'avez pas de compte Administrateur.");
                return back()->with('error', "Compte non autorisé.");
            }
        } else {
            Alert::error('Compte inexistant', "Pas de compte avec cet email.");
            return back()->with('error', "Compte inexistant.");
        }

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
