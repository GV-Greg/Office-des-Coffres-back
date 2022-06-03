<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends BaseController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:191|unique:users',
            'email' => 'required|email|max:191|unique:users',
            'password' => 'required|min:8|max:191',
            'confirmation' => 'required|min:8|max:191|same:password'
        ]);

        if($validator->fails()){
            return $this->sendError('Inscription échouée.', $validator->errors());
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $success['token'] =  $user->createToken(config('app.name'))->accessToken;
        $success['username'] =  $user->username;

        return $this->sendResponse($success, 'Inscription réussie.');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:191|exists:users,username',
            'password' => 'required|min:8|max:191',
        ]);

        if($validator->fails()){
            return $this->sendError('Connexion échouée.', $validator->errors());
        }

        $user = User::where('username', $request->username)->first();

        if($user) {
            if($user->is_validated === true) {
                if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                    $user = Auth::user();
                    $success['token'] =  $user->createToken(config('app.name'))->accessToken;
                    $success['username'] =  $user->username;
                    return $this->sendResponse($success, 'Connexion réussie.');
                } else {
                    return $this->sendError('Mot de passe incorrect', ['password' => "Le mot de passe est incorrect."]);
                }
            } else {
                return $this->sendError('Compte non validé', ['is_validated' => "Votre compte n'est pas validé."]);
            }
        } else {
            return $this->sendError('Compte inexistant', ['pseudo' => "Il n'y a pas de compte avec ce pseudo."]);
        }
    }

    public function check()
    {
        $user = Auth::user()->first();
        $userRoles = $user->getRoleNames();

        return response()->json(['success' => $user, 'userRoles' => $userRoles], 200);
    }


    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        $success['data'] = 'Vous êtes déconnecté';

        return $this->sendResponse($success, 'Déconnexion réussie.');
    }
}
