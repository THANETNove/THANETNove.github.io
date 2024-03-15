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


        $data = DB::table('durable_articles_damageds')
        ->where('durable_articles_damageds.status', '<', 2)
        ->join('users', 'durable_articles_damageds.id_user', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('durable_articles', 'durable_articles_damageds.durable_articles_id', '=', 'durable_articles.code_DurableArticles')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->leftJoin('type_categories', 'durable_articles_damageds.durable_articles_name', '=', 'type_categories.id')
        ->leftJoin('categories', 'durable_articles_damageds.group_id', '=', 'categories.id')
        ->select('durable_articles_damageds.*', 'users.prefix', 'users.first_name','users.last_name','departments.department_name',
    'durable_articles.durableArticles_name','categories.category_name','type_categories.type_name','storage_locations.building_name','storage_locations.floor','storage_locations.room_name');


       if ($search) {
        $data =  $data
            ->where('categories.category_name', 'LIKE', "%$search%")
            ->orWhere('type_categories.type_name', 'LIKE', "%$search%")
            ->orWhere('durable_articles.durableArticles_name', 'LIKE', "%$search%");

        }

       /*  if (Auth::user()->status == "0") {
            $data = $data->where('durable_articles_damageds.id_user', Auth::user()->id);
        } */

        $data = $data->orderBy('durable_articles_damageds.id','DESC')->paginate(100);

        return view("durable_articles_damaged.index",['data' => $data]);
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {

        $group = DB::table('categories')
        ->where('category_id', '=', 2)->orderBy('id', 'ASC')->get();

        return view("durable_articles_damaged.create",['group' =>$group]);
    }

    public function store(Request $request)
    {



        $data = new DurableArticlesDamaged;
        $data->id_user = Auth::user()->id;
        $data->group_id = $request['group_id'];
        $data->durable_articles_id = $request['durable_articles_id'];
        $data->code_durable_articles = $request['code_durable_articles'];
        $data->durable_articles_name = $request['durable_articles_name'];
        $data->amount_damaged = $request['amount_withdraw'];
        $data->name_durable_articles_count = $request['name_durable_articles_count'];
        $data->damaged_detail = $request['damaged_detail'];
        $data->status = "0";
        $data->save();





        DurableArticles::where('id', $request['durable_articles_id'])->update([
            'remaining_amount' =>  0,
            'damaged_number' => 1,
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
        ->leftJoin('durable_articles', 'durable_articles_damageds.durable_articles_name', '=', 'durable_articles.id')
        ->leftJoin('categories', 'durable_articles_damageds.group_id', '=', 'categories.id')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->select('durable_articles_damageds.*','durable_articles.durableArticles_name',
        'durable_articles.remaining_amount','durable_articles.durableArticles_number','categories.category_name','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
    ->get();


        return view('durable_articles_damaged.edit',['data' =>$data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {



        $data = DurableArticlesDamaged::find($id);
        $dataArt = DurableArticles::find($data->durable_articles_name);


            if ($data["amount_damaged"] !=  $request["remaining_amount"]) {
                $amount = ($data["amount_damaged"] +  $dataArt["remaining_amount"]) - $request["amount_damaged"];
                DurableArticles::where('id', $data->durable_articles_name)->update([
                    'remaining_amount' =>  $amount,
                    'damaged_number' =>  ($dataArt->damaged_number - $data->amount_damaged) +  $request["amount_damaged"],

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
        $data = DB::table('durable_articles')
        ->where('code_DurableArticles', $data_damaged->durable_articles_id)
        ->get();
       /*  $data = DurableArticles::find($data_damaged->durable_articles_name); */


        DurableArticles::where('code_DurableArticles', $data_damaged->durable_articles_id)->update([
            'remaining_amount' =>  $data[0]->remaining_amount + $data_damaged->amount_damaged,
            'damaged_number' => $data[0]->damaged_number - $data_damaged->amount_damaged,
        ]);

        DurableArticlesDamaged::where('id', $id)->update([
            'status' =>  "1",
        ]);

        return redirect('durable-articles-damaged-index')->with('message', "ยกเลิกสำเร็จ");
    }

    public function exportPDF()
    {
        $currentYear = date('Y');

        $data = DB::table('durable_articles_damageds')
        ->where('durable_articles_damageds.status', '=', 0)
        ->whereYear('durable_articles_damageds.created_at', $currentYear)
        ->join('users', 'durable_articles_damageds.id_user', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('durable_articles', 'durable_articles_damageds.durable_articles_name', '=', 'durable_articles.id')
        ->leftJoin('categories', 'durable_articles_damageds.group_id', '=', 'categories.id')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->select('durable_articles_damageds.*', 'users.prefix', 'users.first_name','users.last_name','departments.department_name',
    'durable_articles.durableArticles_name','categories.category_name','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
        ->get();
        $pdf = PDF::loadView('durable_articles_damaged.exportPDF',['data' =>  $data,'currentYear' => $currentYear]);
        $pdf->setPaper('a4');
       return $pdf->stream('exportPDF.pdf');
    }
}
