<?php

namespace App\Http\Controllers\Modules\Anim;

use App\Http\Controllers\Controller;
use App\Models\AnimCodeActivity;
use App\Models\AnimCodeProposals;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityDecodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:code-crud');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $activities = AnimCodeActivity::all();

        return view('anim.decode.list', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('anim.decode.create');
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
            'name' => ['required', 'string', 'min:3', 'max:190', 'unique:anim_code_activity,name']
        ]);

        $activity_id = AnimCodeActivity::insertGetId([
            'name' => $request->name,
            'creator_id' => Auth::id(),
            'status' => 'new',
            'created_at' => now()
        ]);

        return redirect()->route('anim.decode.show-activity', $activity_id)->with('toast_success', __('Activity created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $activity = AnimCodeActivity::where('id', $id)->with('latestCode')->first();
        if($activity->latestCode != null) {
            $proposals = AnimCodeProposals::where('code_id', $activity->latestCode->id)->get();
        } else {
            $proposals = null;
        }

        return view('anim.decode.show-activity', compact('activity', 'proposals'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        return view('anim.decode.edit');
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
            'name' => ['required', 'string', 'min:3', 'max:190', 'unique:anim_code_activity,name,'.$id]
        ]);

        return redirect()->route('anim.decode.show', $id)->with('toast_success', __('Activity updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        AnimCodeActivity::where('id', $id)->delete();

        return redirect()->route('anim.decode.list')->with('toast_success', __('Activity deleted'));
    }
}
