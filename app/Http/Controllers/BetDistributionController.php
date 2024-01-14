<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DurableArticles;
use DB;
use Auth;
use PDF;


class BetDistributionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('bet_distribution.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $group = DB::table('categories')
        ->where('category_id', '=', 2)
        ->where('durable_articles_damageds.status', '=', 0)
        ->rightJoin('durable_articles_damageds', 'categories.id', '=', 'durable_articles_damageds.group_id')
        ->groupBy('group_id')
        ->orderBy('categories.id', 'ASC')
        ->select('categories.*')
        ->get();



        return view("bet_distribution.create",['group' => $group]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = new DurableArticlesRepair;
        $data->id_user = Auth::user()->id;
        $data->group_id = $request['group_id'];
        $data->durable_articles_id = $request['durable_articles_id'];
        $data->code_durable_articles = $request['code_durable_articles'];
        $data->durable_articles_name = $request['durable_articles_name'];
        $data->amount_repair = $request['amount_repair'];
        $data->name_durable_articles_count = $request['name_durable_articles_count'];
        $data->repair_detail = $request['repair_detail'];
        $data->status = "0";
        $data->save();



        $repair =  $request['amount_repair'];
        $remaining = $request['remaining_amount'];

        $amount =  $remaining - $repair;
        $amount_repair = DurableArticles::find($request['durable_articles_name']);



        DurableArticles::where('id', $request['durable_articles_name'])->update([
            'repair_number' => $amount_repair->repair_number + $repair,
        ]);
        DurableArticlesDamaged::where('id', $request['durable_articles_id'])->update([
            'status' => "3", // ส่งซ่อม
        ]);


        return redirect('durable-articles-repair-index')->with('message', "บันทึกสำเร็จ");
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
        //
    }
}
