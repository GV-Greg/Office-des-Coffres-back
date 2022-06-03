<?php

namespace App\Http\Controllers\Modules\Anim;

use App\Http\Controllers\Controller;
use App\Models\AnimRewardsGrid;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RewardsGridController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:festival-create', ['only' => 'create', 'store']);
        $this->middleware('permission:festival-show', ['only' => 'index', 'show']);
        $this->middleware('permission:festival-edit', ['edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $grids = AnimRewardsGrid::all();

        return view('anim.grids-rewards.list', compact('grids'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('anim.grids-rewards.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:191', 'unique:anim_rewards_grids,name'],
            'width' => ['required', 'integer', 'min:3', 'max:20'],
            'height' => ['required', 'integer', 'min:3', 'max:20'],
        ]);

        $grid_id = AnimRewardsGrid::insertGetId([
            'name' => $request->name,
            'creator_id' => Auth::id(),
            'width' => $request->width,
            'height' => $request->height,
            'status' => 'new'
        ]);

        return redirect()->route('anim.grid.rewards.show', $grid_id)->with('toast_success', __('Grid created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show(int $id): View
    {
        $grid = AnimRewardsGrid::where('id', $id)->with('rewards')->first();
        $rewards = json_decode(json_encode($grid->rewards->groupBy('name')->all()), true);
        $grid_rewards = $grid->rewards->sortBy('place')->all();
        $rewards_count = $grid->rewards->count();

        return view('anim.grids-rewards.show', compact('grid', 'rewards', 'grid_rewards', 'rewards_count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id): View
    {
        $grid = AnimRewardsGrid::findOrFail($id);

        return view('anim.grids-rewards.edit', compact('grid'));
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
            'name' => ['required', 'string', 'min:3', 'max:191', 'unique:anim_rewards_grids,name,'.$id],
            'width' => ['required', 'integer', 'min:3', 'max:25'],
            'height' => ['required', 'integer', 'min:3', 'max:25'],
        ]);

        $grid_id = AnimRewardsGrid::update([
            'name' => $request->name,
            'width' => $request->width,
            'height' => $request->height,
        ]);

        return redirect()->route('anim.grid.rewards.show', $grid_id)->with('toast_success', __('Grid updated'));
    }

    public function confirm(int $id): RedirectResponse{
        AnimRewardsGrid::where('id',$id)->update([
            'status' => 'confirmed'
        ]);

        return redirect()->route('anim.grid.rewards.show', $id)->with('toast_success', __('Grid confirmed'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        AnimRewardsGrid::findOrFail($id)->delete();

        return redirect()->route('anim.grids.rewards.list')->with('toast_success', __('Grid deleted'));
    }
}
