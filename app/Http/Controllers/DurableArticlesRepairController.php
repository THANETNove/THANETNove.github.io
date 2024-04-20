<?php

namespace App\Http\Controllers;
use App\Models\DurableArticlesRepair;
use App\Models\DurableArticles;
use App\Models\DurableArticlesDamaged;
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
    public function index(Request $request)
    {

        $search =  $request['search'];

        $data = DB::table('durable_articles_repairs')
        ->leftJoin('durable_articles', 'durable_articles_repairs.durable_articles_id', '=', 'durable_articles.id')
        ->leftJoin('type_categories', 'durable_articles_repairs.durable_articles_name', '=', 'type_categories.id')
        ->leftJoin('categories', 'durable_articles_repairs.group_id', '=', 'categories.id')
        ->select('durable_articles_repairs.*','durable_articles.durableArticles_name','categories.category_name','type_categories.type_name');

       if ($search) {
        $data =  $data
            ->where('categories.category_name', 'LIKE', "%$search%")
            ->orWhere('type_categories.type_name', 'LIKE', "%$search%")
            ->orWhere('durable_articles.durableArticles_name', 'LIKE', "%$search%");

        }



        $data = $data->orderBy('durable_articles_repairs.id','DESC')->paginate(100);

        return view("durable_articles_repair.index",['data' => $data]);
    }

    public function create()
    {

        $group = DB::table('durable_articles')
        ->where('category_id', '=', 2)
        ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->leftJoin('durable_articles_damageds', 'durable_articles.id', '=', 'durable_articles_damageds.durable_articles_id')
        ->groupBy('group_id')
        ->orderBy('categories.id', 'ASC')
        ->select('categories.*')
        ->get();


        return view("durable_articles_repair.create",['group' => $group]);
    }


    public function articlesRepair($id)
    {



        $data = DB::table('durable_articles')
        ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
        ->leftJoin('durable_articles_damageds', 'durable_articles.id', '=', 'durable_articles_damageds.durable_articles_id')
        ->select('type_categories.*')
        ->groupBy('type_categories.type_code')
        ->get();



        return response()->json($data);
    }
    public function detailsRepairName($id)
    {

        $data = DB::table('durable_articles')
        ->rightJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->rightJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
        ->rightJoin('durable_articles_damageds', 'durable_articles.id', '=', 'durable_articles_damageds.durable_articles_id')
        ->select('durable_articles_damageds.*','durable_articles.durableArticles_name','durable_articles.description','durable_articles.group_count',
        'type_categories.type_code','categories.category_code')
        ->where('status_damaged', 0)
        ->where('durable_articles_damageds.status', 0)
        ->groupBy('durable_articles_id')
        ->get();


        return response()->json($data);
    }

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
        $amount_repair = DB::table('durable_articles')
        ->where('code_DurableArticles', $request['durable_articles_id'])
        ->get();




        DurableArticles::where('id', $request['durable_articles_id'])->update([
            'repair_number' => 1,
            'damaged_number' => 0,
        ]);


        DurableArticlesDamaged::where('durable_articles_id', $request['durable_articles_id'])->update([
            'status' => "3", // ส่งซ่อม
        ]);


        return redirect('durable-articles-repair-index')->with('message', "บันทึกสำเร็จ");
    }

    public function edit(string $id)
    {

    $data = DB::table('durable_articles_repairs')
    ->leftJoin('durable_articles', 'durable_articles_repairs.durable_articles_name', '=', 'durable_articles.id')
    ->leftJoin('categories', 'durable_articles_repairs.group_id', '=', 'categories.id')
    ->select('durable_articles_repairs.*','durable_articles.durableArticles_name','categories.category_name')
    ->get();

    return view("durable_articles_repair.edit",['data' => $data]);
    }

    public function update(Request $request ,string $id)
    {

        $data =  DurableArticlesRepair::find($id);
        $data->repair_detail = $request['repair_detail'];
        $data->save();

        return redirect('durable-articles-repair-index')->with('message', "บันทึกสำเร็จ");

    }

    public function destroy($id)
    {


        $data =  DurableArticlesRepair::find($id);
        $dataArt  = DB::table('durable_articles')
        ->where('code_DurableArticles', $data->durable_articles_id)
        ->get();




        DurableArticlesDamaged::where('durable_articles_id',  $data->durable_articles_id)->update([
            'status' =>  "0",

        ]);
        DurableArticles::where('id',  $data->durable_articles_id)->update([
            'repair_number' =>  0,
            'damaged_number' =>   1,

        ]);

        $data->status = "1";
        $data->save();


        return redirect('durable-articles-repair-index')->with('message', "บันทึกสำเร็จ");

    }


    public function updateRepair(Request $request)
    {


        $data =  DurableArticlesRepair::find($request['id']);
        $dataArt  = DB::table('durable_articles')
        ->where('code_DurableArticles', $data->durable_articles_id)
        ->get();





        DurableArticlesDamaged::where('durable_articles_id',  $data->durable_articles_id)->update([
            'status' =>  "3",

        ]);
        DurableArticles::where('id',  $data->durable_articles_id)->update([
            'repair_number' =>   0,
            'remaining_amount' =>   1,

        ]);

        $data->status = "2";
        $data->repair_price = $request['repair_price'];
        $data->save();


        return redirect('durable-articles-repair-index')->with('message', "บันทึกสำเร็จ");

    }

    public function exportPDF()
    {
        $currentYear = date('Y');

        $data = DB::table('durable_articles_repairs')
        ->whereYear('durable_articles_repairs.created_at', $currentYear)
        ->leftJoin('durable_articles', 'durable_articles_repairs.durable_articles_name', '=', 'durable_articles.id')
        ->leftJoin('categories', 'durable_articles_repairs.group_id', '=', 'categories.id')
        ->select('durable_articles_repairs.*','durable_articles.durableArticles_name','categories.category_name')
        ->get();
        $pdf = PDF::loadView('durable_articles_repair.exportPDF',['data' =>  $data,'currentYear' => $currentYear]);
        $pdf->setPaper('a4');
       return $pdf->stream('exportPDF.pdf');
    }
}
