<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DurableArticles;
use App\Models\BetDistribution;
use App\Models\DurableArticlesDamaged;
use Illuminate\Support\Facades\DB;
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
            ->leftJoin('durable_articles', 'bet_distributions.durable_articles_id', '=', 'durable_articles.id')
            ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
            ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
            ->select('bet_distributions.*', 'durable_articles.durableArticles_name', 'categories.category_name', 'type_categories.type_name');


        if ($search) {
            $data =  $data
                ->where('categories.category_name', 'LIKE', "%$search%")
                ->orWhere('type_categories.type_name', 'LIKE', "%$search%")
                ->orWhere('durable_articles.durableArticles_name', 'LIKE', "%$search%");
        }



        $data = $data->orderBy('bet_distributions.id', 'DESC')->paginate(100);

        return view('bet_distribution.index', ['data' => $data]);
    }


    public function indexApproval(Request $request)
    {
        $search =  $request['search'];

        $data = DB::table('bet_distributions')
            ->where('bet_distributions.status', '=', "on")
            ->where('bet_distributions.statusApproval', '=', "0")
            ->leftJoin('durable_articles', 'bet_distributions.durable_articles_id', '=', 'durable_articles.id')
            ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
            ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
            ->select('bet_distributions.*', 'durable_articles.durableArticles_name', 'categories.category_name', 'type_categories.type_name');


        if ($search) {
            $data =  $data
                ->where('category_name', 'LIKE', "%$search%")
                ->orWhere('durableArticles_name', 'LIKE', "%$search%");
        }



        $data = $data->orderBy('bet_distributions.id', 'DESC')->paginate(100);

        return view('bet_distribution.indexApproval', ['data' => $data]);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /*
        $group = DB::table('durable_articles')
        ->where('category_id', '=', 2)
        ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->leftJoin('durable_articles_damageds', 'durable_articles.id', '=', 'durable_articles_damageds.durable_articles_id')
        ->groupBy('group_id')
        ->orderBy('categories.id', 'ASC')
        ->select('categories.*')
        ->get();
 */
        $group = DB::table('durable_articles_damageds')
            ->leftJoin('durable_articles', 'durable_articles_damageds.durable_articles_id', '=', 'durable_articles.id')
            ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
            ->groupBy('categories.id')
            ->orderBy('categories.id', 'ASC')
            ->where('category_id', '=', 2)
            ->where('status_damaged', '=', 1)
            ->select('durable_articles_damageds.*', 'categories.category_name', 'categories.category_code')
            ->get();


        return view("bet_distribution.create", ['group' => $group]);
    }

    public function betDistribution($id)
    {


        $data = DB::table('durable_articles_damageds')
            ->where('durable_articles_damageds.group_id', $id)
            ->where('durable_articles_damageds.status', 0)
            ->leftJoin('durable_articles', 'durable_articles_damageds.durable_articles_name', '=', 'durable_articles.id')
            ->leftJoin('bet_distributions', function ($join) {
                $join->on('bet_distributions.code_durable_articles', '=', 'durable_articles_damageds.code_durable_articles')
                    ->where('bet_distributions.status', '<', 2);
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
        $validated = $request->validate([
            'pdf_file' => ['required', 'file', 'mimes:pdf'],
        ]);

        $data = new BetDistribution;
        $data->id_user = Auth::user()->id;
        $data->group_id = $request['group_id'];
        $data->durable_articles_id = $request['durable_articles_id'];
        $data->code_durable_articles = $request['code_durable_articles'];
        $data->durable_articles_name = $request['durable_articles_name'];
        $data->amount_bet_distribution = $request['amount_repair'];
        $data->name_durable_articles_count = $request['name_durable_articles_count'];
        $data->salvage_price = $request['salvage_price'];
        $data->repair_detail = $request['repair_detail'];
        $data->status = "on";
        $data->statusApproval = "0";


        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $extension = $pdfFile->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;

            $pdfFile->move(public_path() . '/pdf', $fileName);

            $data->url_pdf = $fileName;
        }

        $data->save();

        $repair =  $request['amount_repair'];
        $remaining = $request['remaining_amount'];

        $amount =  $remaining - $repair;
        $amount_repair = DB::table('durable_articles')
            ->where('code_DurableArticles', $request['durable_articles_id'])
            ->get();








        DurableArticles::where('code_DurableArticles', $request['durable_articles_id'])->update([
            'bet_on_distribution_number' => 1,
            'damaged_number' => 0,

        ]);
        DurableArticlesDamaged::where('durable_articles_id', $request['durable_articles_id'])->update([
            'status' => "4", // เเทงจำหน่าย
        ]);



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
            ->select('bet_distributions.*', 'durable_articles.durableArticles_name', 'categories.category_name')
            ->get();



        return view("bet_distribution.edit", ['data' => $data]);
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
        $data->statusApproval = "1";
        $data->save();

        $dataArt = DB::table('durable_articles')
            ->where('code_DurableArticles', $data->durable_articles_id)
            ->get();
        DurableArticles::where('id', $data->durable_articles_id)->update([

            'damaged_number' => 0,
            'bet_on_distribution_number' => 1
        ]);


        return redirect('bet-distribution-indexApproval')->with('message', "บันทึกสำเร็จ");
    }


    public function notApprovedBetDistribution(Request $request)
    {

        $data =  BetDistribution::find($request["id"]);
        $data->statusApproval = "2";
        $data->commentApproval = $request['commentApproval'];;
        $data->status = "off";
        $data->save();

        DurableArticlesDamaged::where('durable_articles_id', $data->durable_articles_id)->update([
            'status' => "0", // เเทงจำหน่าย
        ]);


        return redirect('bet-distribution-indexApproval')->with('message', "บันทึกสำเร็จ");
    }


    public function destroy(string $id)
    {
        //


        $data =  BetDistribution::find($id);
        $data->status = "off";



        DurableArticlesDamaged::where('durable_articles_id', $data->durable_articles_id)->update([
            'status' => "0", // เเทงจำหน่าย
        ]);

        $data->save();

        return redirect('bet-distribution-index')->with('message', "บันทึกสำเร็จ");
    }

    public function exportPDF()
    {
        $currentYear = date('Y');
        $data = DB::table('bet_distributions')
            ->whereYear('bet_distributions.created_at', $currentYear)
            ->leftJoin('durable_articles', 'bet_distributions.durable_articles_name', '=', 'durable_articles.id')
            ->leftJoin('categories', 'bet_distributions.group_id', '=', 'categories.id')
            ->select('bet_distributions.*', 'durable_articles.durableArticles_name', 'categories.category_name')
            ->get();
        $pdf = PDF::loadView('bet_distribution.exportPDF', ['data' =>  $data, 'currentYear' => $currentYear]);
        $pdf->setPaper('a4');
        return $pdf->stream('exportPDF.pdf');
    }
}
