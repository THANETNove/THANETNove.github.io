<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DurableArticlesDamaged;
use App\Models\DurableArticles;
use DB;
use Auth;
use PDF;

class DurableArticlesDamagedController extends Controller
{
        /**
    * Show the form for creating a new resource.
    */
    public function index()
    {
        return view("durable_articles_damaged.index");
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        return view("durable_articles_damaged.create");
    }

    public function store(Request $request)
    {

        $data = new DurableArticlesDamaged;
        $data->id_user = Auth::user()->id;
        $data->durable_articles_id = $request['durable_articles_id'];
        $data->code_durable_articles = $request['code_durable_articles'];
        $data->durable_articles_name = $request['durable_articles_name'];
        $data->amount_damaged = $request['amount_damaged'];
        $data->name_durable_articles_count = $request['name_durable_articles_count'];
        $data->damaged_detail = $request['damaged_detail'];
        $data->status = "on";
        $data->save();



        $damaged =  $request['amount_damaged'];
        $remaining = $request['remaining_amount'];

      $amount =  $remaining - $damaged;

      DurableArticles::where('id', $request['durable_articles_id'])->update([
            'remaining_amount' =>  $amount,
        ]);

        return redirect('durable-articles-requisition-index')->with('message', "บันทึกสำเร็จ");
    }
}
