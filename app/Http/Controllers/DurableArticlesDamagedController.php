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
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * Display a listing of the resource.
    */
    public function index(Request $request)
    {
        $search =  $request['search'];


        $data = DB::table('durable_articles_damageds')->join('users', 'durable_articles_damageds.id_user', '=', 'users.id')
        ->select('durable_articles_damageds.*', 'users.prefix', 'users.first_name','users.last_name');

       if ($search) {
        $data =  $data
            ->where('code_durable_articles', 'LIKE', "%$search%")
            ->orWhere('durable_articles_name', 'LIKE', "%$search%")
            ->orWhere(function ($query) use ($search) {
                // Split the full name into prefix, first name, and last name
                $fullNameComponents = explode(' ', $search);
                // Check each component separately
                foreach ($fullNameComponents as $component) {
                    $query->orWhere('prefix', 'LIKE', "%$component%")
                        ->orWhere('first_name', 'LIKE', "%$component%")
                        ->orWhere('last_name', 'LIKE', "%$component%");
                }
            });
        }

        if (Auth::user()->status == "0") {
            $data = $data->where('durable_articles_damageds.id_user', Auth::user()->id);
        }

        $data = $data->orderBy('durable_articles_damageds.id','DESC')->paginate(100);

        return view("durable_articles_damaged.index",['data' => $data]);
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
        $amount_damaged = DurableArticles::find($request['durable_articles_id']);



        DurableArticles::where('id', $request['durable_articles_id'])->update([
            'remaining_amount' =>  $amount,
            'damaged_number' => $amount_damaged->damaged_number + $damaged,
        ]);


        return redirect('durable-articles-damaged-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data =   DB::table('durable_articles_damageds')

        ->where('durable_articles_damageds.id', $id)
        ->join('durable_articles', 'durable_articles_damageds.durable_articles_id', '=', 'durable_articles.id')
        ->select('durable_articles_damageds.*', 'durable_articles.remaining_amount')
        ->get();


        return view('durable_articles_damaged.edit',['data' =>$data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {



        $data = DurableArticlesDamaged::find($id);


            if ($data["amount_damaged"] !=  $request["remaining_amount"]) {
                $amount = $data["amount_damaged"] +  $request["remaining_amount"];
                $amount_wit =  $amount - $request["amount_damaged"];

                DurableArticles::where('id', $id)->update([
                    'remaining_amount' =>  $amount_wit
                ]);

            }

            DurableArticlesDamaged::where('id', $id)->update([
                'amount_damaged' =>   $request["amount_damaged"],
                'damaged_detail' =>   $request["damaged_detail"],
            ]);




        return redirect('durable-articles-damaged-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data_damaged = DurableArticlesDamaged::find($id);
        $data = DurableArticles::find($data_damaged->durable_articles_id);
        DurableArticles::where('id', $data_damaged->durable_articles_id)->update([
            'remaining_amount' =>  $data->remaining_amount + $data_damaged->amount_damaged,
            'damaged_number' => $data->damaged_number - $data_damaged->amount_damaged,
        ]);
        DurableArticlesDamaged::where('id', $id)->update([
            'status' =>  "off",
        ]);

        return redirect('durable-articles-damaged-index')->with('message', "ยกเลิกสำเร็จ");
    }
}
