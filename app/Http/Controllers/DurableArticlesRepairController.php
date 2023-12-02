<?php

namespace App\Http\Controllers;
use App\Models\DurableArticlesRepair;
use App\Models\DurableArticles;
use DB;
use Auth;
use PDF;

use Illuminate\Http\Request;

class DurableArticlesRepairController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        return view("durable_articles_repair.create");
    }

    public function store(Request $request)
    {

        $data = new DurableArticlesRepair;
        $data->id_user = Auth::user()->id;
        $data->durable_articles_id = $request['durable_articles_id'];
        $data->code_durable_articles = $request['code_durable_articles'];
        $data->durable_articles_name = $request['durable_articles_name'];
        $data->amount_repair = $request['amount_repair'];
        $data->name_durable_articles_count = $request['name_durable_articles_count'];
        $data->repair_detail = $request['repair_detail'];
        $data->status = "on";
        $data->save();



        $repair =  $request['amount_repair'];
        $remaining = $request['remaining_amount'];

        $amount =  $remaining - $repair;
        $amount_repair = DurableArticles::find($request['durable_articles_id']);
        
        

        DurableArticles::where('id', $request['durable_articles_id'])->update([
            'remaining_amount' =>  $amount,
            'repair_number' => $amount_repair->repair_number + $repair,
        ]);
        

        return redirect('durable-articles-repair-index')->with('message', "บันทึกสำเร็จ");
    }
}
