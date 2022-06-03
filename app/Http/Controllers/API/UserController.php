<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Util\Type;

class UserController extends BaseController
{
    /**
     * @param Type|null $var
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Type $var = null)
    {
        $players = User::all();

        return $this->sendResponse($players, 'Liste des joueurs.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $player = User::findOrFail($id);

        return $this->sendResponse($player, 'Fiche du joueur.');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $player = new User();
        $player->username = $request->input('username');
        $player->email = $request->input('email');
        $player->password = Hash::make($request->input('password'));
        $player->save();

        return $this->sendResponse($player, 'Joueur créé.');
    }

    public function edit(int $id)
    {
        $player = User::findOrFail($id);

        return $this->sendResponse($player, 'Édition joueur.');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $player = User::findOrFail($id);
        $player->username = $request->input('username');
        $player->email = $request->input('email');
        if($request->input('password')) {
            $player->password = Hash::make($request->input('password'));
        }
        $player->save();

        return $this->sendResponse($player, 'Joueur mis à jour.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id)
    {
        $player = User::findOrFail($id);
        $player->delete();

        return $this->sendResponse($player, 'Joueur supprimé.');
    }
}
