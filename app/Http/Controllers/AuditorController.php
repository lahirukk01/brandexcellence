<?php

namespace App\Http\Controllers;

use App\Auditor;
use App\BlockedEntry;
use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuditorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth:auditor');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $panels = Auth::user()->panels;

        $panelNames = implode(',', $panels->pluck('name')->toArray());

        $data = [];

        foreach ($panels as $p) {
            $judges = $p->judges;
            $categories = $p->categories;

            foreach ($categories as $c) {
                $brands = $c->brands()->where('r2_selected', true)->get();
                foreach ($brands as $b) {
                    $allowedJudgeIds = [];
                    $numberOfAllowedJudges = 0;
                    foreach ($judges as $j) {
                        $count = BlockedEntry::whereJudgeId($j->id)->whereBrandId($b->id)->count();
                        if($count == 0) {
                        //Entry has not been blocked for the judge
                            $allowedJudgeIds[] = $j->id;
                            $numberOfAllowedJudges++;
                        } else {
                            continue;
                        }
                    }
                    $count2 = DB::table('brand_judge')->where('brand_id', $b->id)
                        ->whereIn('judge_id', $allowedJudgeIds)
                        ->where('round', 2)->count();

                    if($count2 == $numberOfAllowedJudges) {
                        //All allowed judges have scored
                        $totals = DB::table('brand_judge')->where('brand_id', $b->id)
                            ->whereIn('judge_id', $allowedJudgeIds)
                            ->where('round', 2)->pluck('total');

                        $temp = [];
                        $temp['brand'] = $b;
                        $temp['judgeIds'] = json_encode($allowedJudgeIds);

                        if($totals->count() > 3) {
                            $min = $totals->min();
                            $max = $totals->max();
                            $sum = $totals->sum() - $min - $max;
                            $num = $totals->count() - 2;
                            $temp['average'] = $sum / $num;
                        } else {
                            $temp['average'] = $totals->average();
                        }

                        $data[] = $temp;
                    }
                }
            }
        }

        return view('auditor.entries', compact('data', 'panelNames'));
    }

    public function getSummary(Request $request)
    {
        $brandId = $request->brandId;
        $judgeIds = $request->judgeIds;

        $data = DB::table('brand_judge')->where('brand_id', $brandId)
            ->join('judges', 'judges.id', '=', 'brand_judge.judge_id')
            ->whereIn('judge_id', $judgeIds)
            ->where('round', 2)
            ->select('intent', 'content', 'health', 'process', 'performance', 'total', 'judges.name')
            ->get();
        return response()->json($data);
    }

    public function finalizeSelectedEntries(Request $request)
    {
        Brand::whereIn('id', $request->brandIds)->update(['auditor_id' => Auth::user()->id]);
        return response()->json('success');
    }

    public function selfUpdatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string', 'min:3', 'max:15', 'alpha_num',],
            'password' => ['required', 'string', 'min:3', 'max:15', 'alpha_num', 'confirmed'],
        ]);

        $currentPassword = $request->input('current_password');

        if( ! Hash::check( $currentPassword, $user->password)) {
            return redirect()->back()->with('passwordError', 'Invalid current password');
        }

        $password = $request->input('password');

        $user->update([
            'password' => Hash::make($password)
        ]);

        return redirect('auditor')->with('status', 'Password updated successfully');
    }

    public function showInsidePasswordResetForm()
    {
        return view('auditor.reset_password');
    }
}
