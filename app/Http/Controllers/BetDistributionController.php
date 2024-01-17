<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DurableArticles;
use App\Models\BetDistribution;
use App\Models\DurableArticlesDamaged;
use DB;
use Auth;
use PDF;


class BetDistributionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search =  $request['search'];

        $data = DB::table('bet_distributions')
        ->leftJoin('durable_articles', 'bet_distributions.durable_articles_name', '=', 'durable_articles.id')
        ->leftJoin('categories', 'bet_distributions.group_id', '=', 'categories.id')
        ->select('bet_distributions.*','durable_articles.durableArticles_name','categories.category_name');


       if ($search) {
        $data =  $data
            ->where('category_name', 'LIKE', "%$search%")
            ->orWhere('durableArticles_name', 'LIKE', "%$search%");

        }



        $data = $data->orderBy('bet_distributions.id','DESC')->paginate(100);

        return view('bet_distribution.index',['data' => $data  ]);
    }


    public function indexApproval(Request $request)
    {
        $search =  $request['search'];

        $data = DB::table('bet_distributions')
        ->where('bet_distributions.status', '=', "on")
        ->where('bet_distributions.statusApproval', '=', "0")
        ->leftJoin('durable_articles', 'bet_distributions.durable_articles_name', '=', 'durable_articles.id')
        ->leftJoin('categories', 'bet_distributions.group_id', '=', 'categories.id')
        ->select('bet_distributions.*','durable_articles.durableArticles_name','categories.category_name');


       if ($search) {
        $data =  $data
            ->where('category_name', 'LIKE', "%$search%")
            ->orWhere('durableArticles_name', 'LIKE', "%$search%");

        }



        $data = $data->orderBy('bet_distributions.id','DESC')->paginate(100);

        return view('bet_distribution.indexApproval',['data' => $data  ]);
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

    public function betDistribution($id)
    {


        $data = DB::table('durable_articles_damageds')
        ->where('durable_articles_damageds.group_id', $id)
        ->where('durable_articles_damageds.status', 0)
        ->leftJoin('durable_articles', 'durable_articles_damageds.durable_articles_name', '=', 'durable_articles.id')
        ->leftJoin('bet_distributions', function ($join) {
            $join->on('bet_distributions.code_durable_articles', '=', 'durable_articles_damageds.code_durable_articles')
                ->where('bet_distributions.status', '<' ,2);
        })
        ->select('durable_articles_damageds.*', 'durable_articles.durableArticles_name')
        ->whereNull('bet_distributions.id') // Check if there is no corresponding record in bet_distributions
        ->orderBy('durable_articles_damageds.id', 'ASC')
        ->get();


        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = new BetDistribution;
        $data->id_user = Auth::user()->id;
        $data->group_id = $request['group_id'];
        $data->durable_articles_id = $request['durable_articles_id'];
        $data->code_durable_articles = $request['code_durable_articles'];
        $data->durable_articles_name = $request['durable_articles_name'];
        $data->amount_bet_distribution = $request['amount_bet_distribution'];
        $data->name_durable_articles_count = $request['name_durable_articles_count'];
        $data->salvage_price = $request['salvage_price'];
        $data->repair_detail = $request['repair_detail'];
        $data->status = "on";
        $data->statusApproval = "0";
        $data->save();



        return redirect('bet-distribution-index')->with('message', "บันทึกสำเร็จ");
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
        $data = DB::table('bet_distributions')
        ->where('bet_distributions.id', '=', $id)
        ->leftJoin('durable_articles', 'bet_distributions.durable_articles_name', '=', 'durable_articles.id')
        ->leftJoin('categories', 'bet_distributions.group_id', '=', 'categories.id')
        ->select('bet_distributions.*','durable_articles.durableArticles_name','categories.category_name')
        ->get();



        return view("bet_distribution.edit",['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data =  BetDistribution::find($id);
        $data->repair_detail = $request['repair_detail'];
        $data->salvage_price = $request['salvage_price'];
        $data->save();
        return redirect('bet-distribution-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function approvedBetDistribution(string $id)
    {
        $data =  BetDistribution::find($id);
        $dataArt =  DurableArticles::find($data['durable_articles_name']);
        $data->statusApproval = "1";

        DurableArticles::where('id', $data['durable_articles_name'])->update([
            'bet_on_distribution_number' => $dataArt->bet_on_distribution_number + $data->amount_bet_distribution,
            'durableArticles_number' => $dataArt->durableArticles_number - $data->amount_bet_distribution,
            'damaged_number' => $dataArt->damaged_number - $data->amount_bet_distribution,
        ]);

        DurableArticlesDamaged::where('id', $data['durable_articles_id'])->update([
            'status' => "4", // เเทงจำหน่าย
        ]);

        $data->save();

        return redirect('bet-distribution-indexApproval')->with('message', "บันทึกสำเร็จ");
    }


    public function notApprovedBetDistribution(Request $request)
    {

        $data =  BetDistribution::find($request["id"]);
        $data->statusApproval = "2";
        $data->commentApproval = $request['commentApproval'];;
        $data->save();
        return redirect('bet-distribution-indexApproval')->with('message', "บันทึกสำเร็จ");
    }
    public function destroy(string $id)
    {
        //


        $data =  BetDistribution::find($id);
        $dataArt =  DurableArticles::find($data['durable_articles_name']);
        $data->status = "off";

        DurableArticles::where('id', $data['durable_articles_name'])->update([
            'bet_on_distribution_number' => $dataArt->bet_on_distribution_number - $data->amount_bet_distribution,
            'durableArticles_number' => $dataArt->durableArticles_number + $data->amount_bet_distribution,
            'damaged_number' => $dataArt->damaged_number + $data->amount_bet_distribution,
        ]);

        DurableArticlesDamaged::where('id', $data['durable_articles_id'])->update([
            'status' => "0", // เเทงจำหน่าย
        ]);

        $data->save();

        return redirect('bet-distribution-index')->with('message', "บันทึกสำเร็จ");

    }

    public function exportPDF()
    {
        $data = DB::table('bet_distributions')
        ->leftJoin('durable_articles', 'bet_distributions.durable_articles_name', '=', 'durable_articles.id')
        ->leftJoin('categories', 'bet_distributions.group_id', '=', 'categories.id')
        ->select('bet_distributions.*','durable_articles.durableArticles_name','categories.category_name')
        ->get();
        $pdf = PDF::loadView('bet_distribution.exportPDF',['data' =>  $data]);
        $pdf->setPaper('a4');
       return $pdf->stream('exportPDF.pdf');
    }
}
