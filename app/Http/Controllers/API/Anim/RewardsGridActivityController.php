<?php

namespace App\Http\Controllers\API\Anim;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\AnimRewardsGrid;
use Illuminate\Http\JsonResponse;

class RewardsGridActivityController extends BaseController
{
    public function activity(string $name): JsonResponse
    {
        $grid = AnimRewardsGrid::where('name', $name)->with('rewards')->first();
        $activity['grid'] = AnimRewardsGrid::where('name', $name)->first();
        $activity['rewards'] = collect($grid->rewards->sortBy('place')->values()->all());
        $activity['rewardsPerPlayer'] = collect($grid->rewards->whereNotNull('player')->sortBy('player')->values()->all())->groupBy('player');

        return $this->sendResponse($activity, 'Grille téléchargée.');
    }
}
