<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends BaseController
{
    function __construct()
    {
        $this->middleware('permission:user-crud');
//        $this->middleware('permission:user-list', ['only' => ['index']]);
//        $this->middleware('permission:user-create', ['only' => ['create','store']]);
//        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $players = User::orderBy('id','ASC')->paginate(8);

        return view('players.list', compact('players'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('players.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'pseudo' => ['required', 'string', 'max:191', 'unique:users,pseudo'],
            'email' => ['required', 'string', 'max:191', 'unique:users,email'],
            'password' => ['required', Password::defaults()],
        ]);

        User::create([
            'pseudo' => $request->pseudo,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $players = User::all();

        return redirect()->route('players.list', compact('players'))->with('success', 'Joueur créé');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(int $id)
    {
        $player = User::findOrFail($id);

        return view('players.show', compact('player'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $player = User::findOrFail($id);

        return view('players.edit', compact('player'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'pseudo' => ['required', 'string', 'max:191', 'unique:users,pseudo,'.$id],
            'email' => ['required', 'string', 'max:191', 'unique:users,email,'.$id],
            'password' => ['nullable', Password::defaults()],
        ]);

        $player = User::findOrFail($id);
        $player->pseudo = $request->pseudo;
        $player->email = $request->email;
        if($request->password !== null){
            $player->password = Hash::make($request->password);
        }
        $player->save();

        $players = User::all();

        return redirect()->route('players.list', compact('players'))->with('success', 'Joueur mis à jour');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        User::findOrFail($id)->delete();

        return redirect()->route('players.list');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function changeStatus(int $id): RedirectResponse
    {
        $player = User::findOrFail($id);

        $player->update([
            'is_validated' => !$player->is_validated,
        ]);

        $players = User::all();

        return redirect()->route('players.list', compact('players'));
    }
}
