<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\CsrScore;
use App\Judge;
use App\Sme;
use App\SmeScore;
use Illuminate\Http\Request;

class AdminBenchmarkController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('admin.benchmarks', compact('categories'));
    }

    public function getBrands(Request $request)
    {
        $category = Category::find($request->categoryId);

        if($category->code == 'SME') {
            $smeIds = SmeScore::whereRound(1)->pluck('sme_id')->unique();

            foreach ($smeIds as $s) {
                $sme  = Sme::find($s);

                $brandArray = [
                    'id' => $sme->id,
                    'name' => $sme->brand_name,
                    'id_string' => $sme->id_string,
                ];

                $smeScores = SmeScore::whereSmeId($sme->id)->whereRound(1)->get();

                $count = $smeScores->count();
                if($count == 0) {
                    continue;
                }

                $average = round($smeScores->pluck('total')->average(), 1);

                if($average < $category->benchmark) {
                    continue;
                }

                $scoreData = [];

                foreach ($smeScores as $ss) {
                    $temp = [];
                    $judge = Judge::find($ss->judge_id);

                    $temp['judge']['name'] = $judge->name;
                    $temp['judge']['id'] = $judge->id;

                    $temp['score']['opportunity'] = $ss->opportunity;
                    $temp['score']['satisfaction'] = $ss->satisfaction;
                    $temp['score']['description'] = $ss->description;
                    $temp['score']['targeting'] = $ss->targeting;
                    $temp['score']['decision'] = $ss->decision;
                    $temp['score']['identity'] = $ss->identity;
                    $temp['score']['pod'] = $ss->pod;
                    $temp['score']['marketing'] = $ss->marketing;
                    $temp['score']['performance'] = $ss->performance;
                    $temp['score']['engagement'] = $ss->engagement;
                    $temp['score']['total'] = $ss->total;
                    $temp['score']['good'] = $ss->good;
                    $temp['score']['bad'] = $ss->bad;
                    $temp['score']['improvement'] = $ss->improvement;

                    $scoreData[] = $temp;
                }

                $data['brands'][] = [
                    'brand' => $brandArray,
                    'average' => round($average, 1),
                    'scoreData' => $scoreData,
                ];

            }
        } else {
            $brands = $category->brands;
            $data = [];

            if($category->code == 'CSR') {
                foreach ($brands as $b) {
                    $total = 0;
                    $count = 0;
                    $scoreData = [];

                    $csrScores = CsrScore::whereBrandId($b->id)->whereRound(1)->get();

                    foreach ($csrScores as $c) {
                        $temp = [];
                        $total += $c->total;
                        $count++;

                        $judge = $c->judge;
                        $temp['judge']['name'] = $judge->name;
                        $temp['judge']['id'] = $judge->id;

                        $temp['score']['intent'] = $c->intent;
                        $temp['score']['recipient'] = $c->recipient;
                        $temp['score']['purpose'] = $c->purpose;
                        $temp['score']['vision'] = $c->vision;
                        $temp['score']['mission'] = $c->mission;
                        $temp['score']['identity'] = $c->identity;
                        $temp['score']['strategic'] = $c->strategic;
                        $temp['score']['activities'] = $c->activities;
                        $temp['score']['communication'] = $c->communication;
                        $temp['score']['internal'] = $c->internal;
                        $temp['score']['total'] = $c->total;
                        $temp['score']['good'] = $c->good;
                        $temp['score']['bad'] = $c->bad;
                        $temp['score']['improvement'] = $c->improvement;

                        $scoreData[] = $temp;
                    }

                    if ($count == 0) {
                        continue;
                    }

                    $average = $total / $count;

                    if ($average < $category->benchmark) {
                        continue;
                    }

                    $data['brands'][] = [
                        'brand' => [
                            'id' => $b->id,
                            'name' => $b->name,
                            'id_string' => $b->id_string,
                        ],
                        'average' => round($average, 1),
                        'scoreData' => $scoreData,
                    ];
                }
            } else {
                foreach ($brands as $b) {
                    $total = 0;
                    $count = 0;
                    $scoreData = [];

                    foreach ($b->judges as $j) {
                        $temp = [];
                        $total += $j->score->total;
                        $count++;

                        $temp['judge']['name'] = $j->name;
                        $temp['judge']['id'] = $j->id;

                        $tempScore = $j->score;
                        $temp['score']['intent'] = $tempScore['intent'];
                        $temp['score']['content'] = $tempScore['content'];
                        $temp['score']['health'] = $tempScore['health'];
                        $temp['score']['process'] = $tempScore['process'];
                        $temp['score']['performance'] = $tempScore['performance'];
                        $temp['score']['total'] = $tempScore['total'];
                        $temp['score']['good'] = $tempScore['good'];
                        $temp['score']['bad'] = $tempScore['bad'];
                        $temp['score']['improvement'] = $tempScore['improvement'];

                        $scoreData[] = $temp;
                    }

                    if ($count === 0) {
                        continue;
                    }

                    $average = $total / $count;

                    if ($average < $category->benchmark) {
                        continue;
                    }

                    $data['brands'][] = [
                        'brand' => [
                            'id' => $b->id,
                            'name' => $b->name,
                            'id_string' => $b->id_string,
                        ],
                        'average' => round($average, 1),
                        'scoreData' => $scoreData,
                    ];
                }
            }
        }

        if(!empty($data['brands'])) {
            usort($data['brands'], function ($a, $b) {
                return $b['average'] <=> $a['average'];
            });
        }

        $data['categoryCode'] = $category->code;

        return response()->json($data);
    }

    public function passBrandsAndCategory(Request $request)
    {
        $categoryId = $request->categoryId;
        $selectedBrandIds = $request->selectedBrandIds;

        $category = Category::findOrFail($categoryId);
        $category->r1_finalized = true;
        $category->save();

        if($category->code == 'SME') {
            $smes = Sme::whereIn('id', $selectedBrandIds)->update(['r2_selected' => true]);
        } else {
            $brands = Brand::find($selectedBrandIds);

            if($brands) {
                foreach ($brands as $b) {
                    $b->r2_selected = true;
                    $b->save();
                }
            }
        }

        return response()->json(['response' => 'success']);
    }
}
