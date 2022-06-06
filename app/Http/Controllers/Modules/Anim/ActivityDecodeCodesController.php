<?php

namespace App\Http\Controllers\Modules\Anim;

use App\Http\Controllers\Controller;
use App\Models\AnimCodeActivity;
use App\Models\AnimCodeCodes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ActivityDecodeCodesController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        $code = '';
        for($i=0; $i < 5; $i++) {
            $code .= strval(rand(0,9));
        }

        AnimCodeCodes::create( [
            'code_activity_id' => $request->code_activity_id,
            'code' => Crypt::encryptString($code),
            'status' => 0,
        ]);

        AnimCodeActivity::where('id', $request->code_activity_id)->update([
            'status' => 'launched'
        ]);

        return redirect()->route('anim.decode.show-activity', $request->code_activity_id)->with('toast_success', __('Mystery code generated'));
    }

    public function show(int $id)
    {
        $code = AnimCodeCodes::where('id', $id)->with('activity')->with('proposals')->first();

        return view('anim.decode.show-code', compact('code'));
    }
}
