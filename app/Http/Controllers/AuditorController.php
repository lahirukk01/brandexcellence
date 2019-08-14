<?php

namespace App\Http\Controllers;

use App\Auditor;
use App\BlockedEntry;
use App\Brand;
use App\BrandJudge;
use App\CsrScore;
use App\Sme;
use App\SmeJudge;
use App\SmeScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuditorController extends Controller
{
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

            if($categories->count() == 1 && $categories->first()->code == 'SME') {
                $secondRoundScoredSmeIds = SmeScore::whereRound(2)->pluck('sme_id');
                $brands = Sme::find($secondRoundScoredSmeIds);
                $allowedJudgeIds = $judges->pluck('id');

                foreach ($brands as $b) {

                    $totals = SmeScore::whereSmeId($b->id)->whereRound(2)->pluck('totals');

                    $temp = [];
                    $temp['brand'] = $b;
                    $temp['judgeIds'] = json_encode($allowedJudgeIds);
                    $temp['categoryCode'] = 'SME';

                    if($totals->count() > 3) {
                        $min = $totals->min();
                        $max = $totals->max();
                        $sum = $totals->sum() - $min - $max;
                        $num = $totals->count() - 2;
                        $temp['average'] = round($sum / $num, 1);
                    } else {
                        $temp['average'] = round($totals->average(), 1);
                    }

                    $data[] = $temp;
                }

            } else {
                foreach ($categories as $c) {
                    if($c->code == 'CSR') {
                        $roundTwoSelectedBrandIds = CsrScore::whereRound(2)->pluck('brand_id');
                    } else {
                        $roundTwoSelectedBrandIds = BrandJudge::whereRound(2)->pluck('brand_id');
                    }

                    $brands = Brand::whereCategoryId($c->id)->whereIn('id', $roundTwoSelectedBrandIds)
                        ->get();
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

                        if($c->code == 'CSR') {
                            $totals = DB::table('csr_scores')->where('brand_id', $b->id)
                                ->whereIn('judge_id', $allowedJudgeIds)
                                ->where('round', 2)->pluck('total');
                        } else {
                            $totals = DB::table('brand_judge')->where('brand_id', $b->id)
                                ->whereIn('judge_id', $allowedJudgeIds)
                                ->where('round', 2)->pluck('total');
                        }

                        $temp = [];
                        $temp['brand'] = $b;
                        $temp['judgeIds'] = json_encode($allowedJudgeIds);
                        $temp['categoryCode'] = $c->code;

                        if($totals->count() > 3) {
                            $min = $totals->min();
                            $max = $totals->max();
                            $sum = $totals->sum() - $min - $max;
                            $num = $totals->count() - 2;
                            $temp['average'] = round($sum / $num, 1);
                        } else {
                            $temp['average'] = round($totals->average(), 1);
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
        $categoryCode = $request->categoryCode;

        if($categoryCode == 'CSR') {
            $data = DB::table('csr_scores')->where('brand_id', $brandId)
                ->join('judges', 'judges.id', '=', 'csr_scores.judge_id')
                ->whereIn('judge_id', $judgeIds)
                ->where('round', 2)
                ->select('intent', 'recipient', 'purpose', 'vision', 'mission', 'identity',
                    'strategic', 'activities', 'communication', 'internal', 'total', 'judges.name')
                ->get();
        } else if($categoryCode == 'SME') {
            $data = DB::table('sme_scores')->where('sme_id', $brandId)
                ->join('judges', 'judges.id', '=', 'sme_scores.judge_id')
                ->whereIn('judge_id', $judgeIds)
                ->where('round', 2)
                ->select('opportunity', 'satisfaction', 'description', 'targeting', 'decision',
                    'identity', 'pod', 'marketing', 'performance', 'engagement', 'total',
                    'judges.name')
                ->get();
        } else {
            $data = DB::table('brand_judge')->where('brand_id', $brandId)
                ->join('judges', 'judges.id', '=', 'brand_judge.judge_id')
                ->whereIn('judge_id', $judgeIds)
                ->where('round', 2)
                ->select('intent', 'content', 'health', 'process', 'performance',
                    'total', 'judges.name')
                ->get();
        }

        return response()->json($data);
    }

    public function finalizeSelectedEntries(Request $request)
    {
        $myData = $request->myData;
        $auditorId = Auth::user()->id;

        foreach ($myData as $d) {
            if($d[0] == 'SME') {
                Sme::whereId($d[1])->update(['auditor_id' => $auditorId]);
            } else {
                Brand::whereId($d[1])->update(['auditor_id' => $auditorId]);
            }
        }

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
