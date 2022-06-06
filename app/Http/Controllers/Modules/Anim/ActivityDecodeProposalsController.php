<?php

namespace App\Http\Controllers\Modules\Anim;

use App\Http\Controllers\Controller;
use App\Models\AnimCodeActivity;
use App\Models\AnimCodeCodes;
use App\Models\AnimCodeProposals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ActivityDecodeProposalsController extends Controller
{
    /**
     * @param Request $request
     * @param int $activity_code_id
     * @return mixed
     */
    public function verify(Request $request, int $activity_code_id)
    {
        $request->validate([
            'combination' => ['required', 'string', 'min:5', 'max:5'],
            'player' => ['required', 'string', 'max:30'],
        ]);

        $code = AnimCodeCodes::where('code_activity_id', $activity_code_id)->latest()->first();
        $codeDecrypt = Crypt::decryptString($code->code);

        $points = $this->calculation($codeDecrypt, $request->combination);

        AnimCodeProposals::create([
            'code_id' => $code->id,
            'combination' => $request->combination,
            'player' => $request->player,
            'points' => $points === 10 ? 20 : $points
        ]);

        if($points === 10) {
            AnimCodeActivity::where('id', $activity_code_id)->update([
                'status' => 'relaunch'
            ]);
            $code->status = 1;
            $code->save();
        }

        if($points === 10) {
            $message = __('Mystery code found');
        } elseif($points > 1) {
            $message = __('Proposal-points', ['points' => $points]);
        } else {
            $message =  __('Proposal-point', ['points' => $points]);
        }

        return redirect()->route('anim.decode.show-activity', $activity_code_id)->with('toast_success', $message);
    }

    /**
     * @param string $code
     * @param string $combination
     * @return int
     */
    function calculation(string $code, string $combination): int
    {
        $points = [];
        $tab_code = str_split($code);
        $tab_combi = str_split($combination);
        // tableau comptant le nombre de chiffres de la même valeur dans la combinaison
        $checks_combi = array_count_values($tab_combi);
        $remind_numbers = [];

        for($i=0; $i < count($tab_combi); $i++) {
            if(!in_array($tab_combi[$i], $tab_code)) {
                $points[$i] = 0;
                $remind_numbers[] = $tab_code[$i];
            } else if($tab_combi[$i] ===  $tab_code[$i]) {
                $points[$i] = 2;
                $checks_combi[$tab_combi[$i]]--;
            } else {
                $points[$i] = null;
                $remind_numbers[] = $tab_code[$i];
            }
        }

        $checks_remind_numbers = array_count_values($remind_numbers);

        for($y=0; $y < count($points); $y++) {
            if($points[$y] === null) {
                if(in_array($tab_combi[$y], $remind_numbers) && $checks_remind_numbers[$tab_combi[$y]] >= 1) {
                    $points[$y] = 1;
                    $checks_remind_numbers[$tab_combi[$y]]--;
                } else {
                    $points[$y] = 0;
                }
            }
        }

        return array_sum($points);
    }
}
