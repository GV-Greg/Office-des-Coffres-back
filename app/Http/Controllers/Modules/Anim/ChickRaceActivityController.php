<?php

namespace App\Http\Controllers\Modules\Anim;

use App\Http\Controllers\Controller;
use App\Models\AnimChickRaceActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChickRaceActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:chick-race-crud');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $activities = AnimChickRaceActivity::all();

        return view('anim.chick-race.list', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('anim.chick-race.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:190', 'unique:anim_chick_race_activity,name']
        ]);

        $activity_id = AnimChickRaceActivity::insertGetId([
            'name' => $request->name,
            'creator_id' => Auth::id(),
            'status' => 'new',
            'created_at' => now()
        ]);

        return redirect()->route('anim.chick-race.show-activity', $activity_id)->with('toast_success', __('Activity created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $activity = AnimChickRaceActivity::where('id', $id)->with('chicks')->first();

        return view('anim.chick-race.show-activity', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        return view('anim.chick-race.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:190', 'unique:anim_chick_race_activity,name,'.$id]
        ]);

        return redirect()->route('anim.chick-race.show', $id)->with('toast_success', __('Activity updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        AnimChickRaceActivity::where('id', $id)->delete();

        return redirect()->route('anim.chick-race.list')->with('toast_success', __('Activity deleted'));
    }

    public function start(int $id)
    {
        AnimChickRaceActivity::where('id', $id)->update([
            'status' => 'launched'
        ]);

        return redirect()->route('anim.chick-race.show-activity', $id)->with('toast_success', __('Race started'));
    }
}
