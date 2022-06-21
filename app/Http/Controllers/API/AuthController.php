<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:191',
            'email' => 'required|email|max:191',
            'password' => 'required|min:8|max:191',
            'confirmation' => 'required|min:8|max:191|same:password'
        ]);

        if($validator->fails()){
            return $this->sendError('Inscription échouée.', $validator->errors());
        }

        $verif_username = User::where('username', $request->username)->exists();
        $verif_email = User::where('email', $request->email)->exists();

        if($verif_username) {
            return $this->sendError('Compte avec pseudo déjà existant', ['username' => "Compte avec ce pseudo déjà existant."]);
        } elseif($verif_email) {
            return $this->sendError('Compte avec email déjà existant', ['email' => "Compte avec cet email déjà existant."]);
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
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:191',
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
                    $success['token'] = $user->createToken(config('app.name'))->accessToken;
                    $success['username'] = $user->username;
                    $success['roles'] = $user->getRoleNames();
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

    /**
     * @param string $username
     * @return JsonResponse
     */
    public function check(string $username): JsonResponse
    {
        $user = User::where('username', $username)->first();
        $success['user'] = $user->username;
        $success['roles'] = $user->getRoleNames();

        return $this->sendResponse($success, 'Roles checkés.');
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        $success['data'] = 'Vous êtes déconnecté';

        return $this->sendResponse($success, 'Déconnexion réussie.');
    }
}
