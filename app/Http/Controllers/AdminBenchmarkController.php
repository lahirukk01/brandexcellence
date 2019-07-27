<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
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
        $brands = $category->brands;

        $data = [];

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

            if($count === 0) {
                continue;
            }

            $average = $total / $count;

            if($average < $category->benchmark) {
                continue;
            }

            $data[] = [
                'brand' => [
                    'id' => $b->id,
                    'name' => $b->name,
                    'id_string' => $b->id_string,
                ],
                'average' => $average,
                'scoreData' => $scoreData,
            ];
        }

        return response()->json($data);
    }

    public function passBrandsAndCategory(Request $request)
    {
        $categoryId = $request->categoryId;
        $selectedBrandIds = $request->selectedBrandIds;

        $category = Category::findOrFail($categoryId);
        $category->r1_finalized = true;
        $category->save();

        $brands = Brand::find($selectedBrandIds);

        if($brands) {
            foreach ($brands as $b) {
                $b->r2_selected = true;
                $b->save();
            }
        }

        return response()->json(['response' => 'success']);
    }
}
