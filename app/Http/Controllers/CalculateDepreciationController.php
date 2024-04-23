<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\DurableArticles;

class CalculateDepreciationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $group = DB::table('categories')
        ->where('category_id', '=', 2)
        ->orderBy('categories.id', 'ASC')
        ->get();
        return view('calculate.create',['group' => $group]);
    }


    public function calculate($id)
    {
        $currentYear = date('Y');


        $data = DB::table('durable_articles')
        ->where('durable_articles.group_class', '=', $id)
        ->where(function ($query) use ($currentYear) {
            $query->whereYear('durable_articles.depreciation_date', '<>', $currentYear)
                  ->orWhereNull('durable_articles.depreciation_date');
        })
        ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')

        ->leftJoin('bet_distributions', 'durable_articles.id', '=', 'bet_distributions.durable_articles_name')

        ->select('durable_articles.*','bet_distributions.salvage_price',
        'bet_distributions.statusApproval','categories.category_code','type_categories.type_code')
        ->orderBy('durable_articles.id', 'ASC')
        ->get();
        return response()->json($data);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $date = Carbon::now()->format('Y-m-d');
        $numberWithoutComma = str_replace(',', '', $request['depreciation']);
        $data =  DurableArticles::find($request['articles_id']);
        $data->depreciation_price = $numberWithoutComma;
        $data->depreciation_date =  $date;
        $data->save();

        return redirect('calculator-create')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {


    }
}
