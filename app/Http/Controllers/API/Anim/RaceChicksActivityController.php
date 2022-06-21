<?php

namespace App\Http\Controllers\API\Anim;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\AnimChickRaceActivity;
use Illuminate\Http\JsonResponse;

class RaceChicksActivityController extends BaseController
{
    /**
     * @param string $name
     * @return JsonResponse
     */
    public function activity(string $name): JsonResponse
    {
        $activity = AnimChickRaceActivity::where('name', $name)->with('chicks')->first();

        return $this->sendResponse($activity, 'Terrain téléchargé.');
    }
}
