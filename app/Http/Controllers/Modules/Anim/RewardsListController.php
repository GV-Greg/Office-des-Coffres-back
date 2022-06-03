<?php

namespace App\Http\Controllers\Modules\Anim;

use App\Http\Controllers\Controller;
use App\Models\AnimRewardsGrid;
use App\Models\AnimRewardsList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RewardsListController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'grid_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'number' => ['required', 'integer', 'min:1'],
        ]);

        $grid = AnimRewardsGrid::where('id', $request->grid_id)->with('rewards')->first();

        $tab = [];
        for($i=0; $i < $request->number; $i++) {
            $tab[] = [
                'grid_id' => $request->grid_id,
                'name' => $request->name,
                'is_taken' => false,
            ];
        }

        $grid->rewards()->createMany($tab);

        $max = $grid->width * $grid->height;

        if($grid->status === 'new') {
            $grid->status = 'incomplete';
            $grid->save();
        } else if(count($grid->rewards) + $request->number === $max) {
            $grid->status = 'filled';
            $grid->save();
        }

        $message = $request->number > 1 ? __('Rewards added') : __('Reward added');

        return redirect()->route('anim.grid.rewards.show', $request->grid_id)->with('toast_success', $message);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function draw(int $id): RedirectResponse
    {
        $grid = AnimRewardsGrid::where('id', $id)->with('rewards')->get()->first();

        $compteur = $grid->width * $grid->height;
        $boxes = [];
        for($x=1; $x < $compteur+1; $x++) {
            $boxes[] = $x;
        }

        shuffle($boxes);

        for($i=0; $i < count($boxes); $i++) {
            $tab[] = [
                'id' => $grid->rewards[$i]->id,
                'grid_id' => $id,
                'name' => $grid->rewards[$i]->name,
                'place' => $boxes[$i],
            ];
        }

        AnimRewardsList::upsert($tab, ['id','grid_id','name'], ['place']);

        $grid->status = 'drawed';
        $grid->save();

        return redirect()->route('anim.grid.rewards.show', $id)->with('toast_success', __('Draw made'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function give(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'player' => ['required', 'string', 'max:40']
        ]);

        $reward = AnimRewardsList::where('id', $id)->first();

        $reward->player = $request->player;
        $reward->is_taken = true;
        $reward->save();

        return redirect()->route('anim.grid.rewards.show',$reward->grid_id)->with('toast_success', __('Reward given to ') . $request->player);
    }

    /**
     * @param int $id
     * @param string $name
     * @return RedirectResponse
     */
    public function destroy(int $id, string $name): RedirectResponse
    {
        $count = AnimRewardsList::where('grid_id', $id)->where('name', $name)->count();
        AnimRewardsList::where('grid_id', $id)->where('name', $name)->delete();

        $grid = AnimRewardsGrid::where('id', $id)->first();
        $grid->status = "incomplete";
        $grid->save();

        $message = $count > 1 ? __('Rewards deleted') : __('Reward delete');

        return redirect()->route('anim.grid.rewards.show', $id)->with('toast_success', $message);

    }
}
