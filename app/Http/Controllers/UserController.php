<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends BaseController
{

    public function __construct()
    {
        $this->middleware('permission:player-crud');
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
            'username' => ['required', 'string', 'max:191', 'unique:users,username'],
            'email' => ['required', 'string', 'max:191', 'unique:users,email'],
            'password' => ['required', Password::defaults()],
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $players = User::all();

        return redirect()->route('players.list', compact('players'))->with('toast_success', __('Player created'));
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
        $player = User::where('id', $id)->with('roles')->first();

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
            'username' => ['required', 'string', 'max:191', 'unique:users,username,'.$id],
            'email' => ['required', 'string', 'max:191', 'unique:users,email,'.$id],
            'password' => ['nullable', Password::defaults()],
        ]);

        $player = User::findOrFail($id);
        $player->username = $request->username;
        $player->email = $request->email;
        if($request->password !== null){
            $player->password = Hash::make($request->password);
        }
        $player->save();

        $players = User::all();

        return redirect()->route('players.list', compact('players'))->with('toast_success', __('Player updated'));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        User::findOrFail($id)->delete();

        return redirect()->route('players.list')->with('toast_success', __('Player deleted'));
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

        return redirect()->route('players.list', compact('players'))->with('toast_success', __('Player status changed'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addRole(int $id)
    {
        $player = User::where('id', $id)->first();
        $roles = Role::all();
        $playerRoles = $player->roles->pluck('id')->toArray();

        return view('players.add-role', compact('player', 'roles', 'playerRoles'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function storeRole(Request $request, int $id): RedirectResponse
    {
        $player = User::findOrFail($id);
        $player->syncRoles($request->roles);

        return redirect()->route('player.show', ['id' => $id, 'player' => $player])->with('toast_success', __('Player roles updated'));
    }
}
