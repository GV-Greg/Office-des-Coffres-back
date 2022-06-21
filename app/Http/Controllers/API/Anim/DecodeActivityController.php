<?php

namespace App\Http\Controllers\API\Anim;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\AnimCodeActivity;
use App\Models\AnimCodeCodes;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;

class DecodeActivityController extends BaseController
{
    /**
     * @param string $name
     * @return JsonResponse
     */
    public function activity(string $name): JsonResponse
    {
        $activity['activity'] = AnimCodeActivity::where('name', $name)->first();
        $activity['codes'] = AnimCodeCodes::where('code_activity_id', $activity['activity']->id)->with('proposals')->get();
        for($i=0; $i < count($activity['codes']); $i++) {
            $activity['codes'][$i]->code = Crypt::decryptString($activity['codes'][$i]->code);
        }

        return $this->sendResponse($activity, 'Liste de codes téléchargée.');
    }
}
