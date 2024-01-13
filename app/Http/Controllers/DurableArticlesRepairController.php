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
        ->leftJoin('durable_articles', 'durable_articles_repairs.durable_articles_name', '=', 'durable_articles.id')
        ->leftJoin('categories', 'durable_articles_repairs.group_id', '=', 'categories.id')
        ->select('durable_articles_repairs.*','durable_articles.durableArticles_name','categories.category_name');


       if ($search) {
        $data =  $data
            ->where('category_name', 'LIKE', "%$search%")
            ->orWhere('durableArticles_name', 'LIKE', "%$search%");

        }



        $data = $data->orderBy('durable_articles_repairs.id','DESC')->paginate(100);


        return view("durable_articles_repair.index",['data' => $data]);
    }

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



        return view("durable_articles_repair.create",['group' => $group]);
    }


    public function articlesRepair($id)
    {

        $data = DB::table('durable_articles_damageds')
        ->where('durable_articles_damageds.group_id', $id)
        ->leftJoin('durable_articles', 'durable_articles_damageds.durable_articles_name', '=', 'durable_articles.id')
        ->select('durable_articles_damageds.*','durable_articles.durableArticles_name')
        ->orderBy('durable_articles_damageds.id', 'ASC')
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
        $amount_repair = DurableArticles::find($request['durable_articles_name']);



        DurableArticles::where('id', $request['durable_articles_name'])->update([
            'repair_number' => $amount_repair->repair_number + $repair,
        ]);
        DurableArticlesDamaged::where('id', $request['durable_articles_name'])->update([
            'status' => "3", // ส่งซ่อม
        ]);


        return redirect('durable-articles-repair-index')->with('message', "บันทึกสำเร็จ");
    }
}
