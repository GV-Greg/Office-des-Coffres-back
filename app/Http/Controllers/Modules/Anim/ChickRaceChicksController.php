<?php

namespace App\Http\Controllers\Modules\Anim;

use App\Http\Controllers\Controller;
use App\Models\AnimChickRaceActivity;
use App\Models\AnimChickRaceChicks;
use Illuminate\Http\Request;

class ChickRaceChicksController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'chick_race_activity_id' => ['required', 'integer'],
            'name_player' => ['required', 'string', 'max:50'],
            'name_chick' => ['required', 'string', 'max:50', 'unique:anim_chick_race_chicks,name_chick,NULL,id,chick_race_activity_id,'.$request->chick_race_activity_id],
            'color' => ['required', 'string', 'in:gray,yellow,orange,black'],
        ]);

        $count = AnimChickRaceChicks::where('chick_race_activity_id', $request->chick_race_activity_id)->count();

        AnimChickRaceChicks::create([
            'chick_race_activity_id' => $request->chick_race_activity_id,
            'name_player' => $request->name_player,
            'name_chick' => $request->name_chick,
            'color' => $request->color,
            'position_x' => 7+($count*3),
            'position_y' => 0
        ]);

        if($count === 0) {
            AnimChickRaceActivity::where('id', $request->chick_race_activity_id)->update([
                'status' => 'prepared'
            ]);
        }

        return redirect()->route('anim.chick-race.show-activity', $request->chick_race_activity_id)->with('toast_success', __('Chick created'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'position_x' => ['required', 'integer', 'min:0', 'max:100'],
            'position_y' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $chick = AnimChickRaceChicks::where('id', $id)->first();

        $chick->update([
            'position_x' => $request->position_x,
            'position_y' => $request->position_y,
        ]);

        return redirect()->route('anim.chick-race.show-activity', $chick->chick_race_activity_id)->with('toast_success', __('Position updated'));
    }
}
