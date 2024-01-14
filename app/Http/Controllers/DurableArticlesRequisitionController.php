<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DurableArticlesRequisition;
use App\Models\DurableArticles;
use DB;
use Auth;
use PDF;

class DurableArticlesRequisitionController extends Controller
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
        $data = DB::table('durable_articles_requisitions')
        ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('durable_articles', 'durable_articles_requisitions.durable_articles_name', '=', 'durable_articles.id')
        ->leftJoin('categories', 'durable_articles_requisitions.group_id', '=', 'categories.id')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->select('durable_articles_requisitions.*', 'users.prefix', 'users.first_name','users.last_name','departments.department_name',
    'durable_articles.durableArticles_name','categories.category_name','storage_locations.building_name','storage_locations.floor','storage_locations.room_name');

       if ($search) {
        $data =  $data
            ->where(function ($query) use ($search) {
                $query->where('category_name', 'LIKE', "%$search%")
                    ->orWhere('durableArticles_name', 'LIKE', "%$search%")
                    ->orWhere('first_name', 'LIKE', "%$search%")
                    ->orWhere('last_name', 'LIKE', "%$search%");
            });
        }

       if (Auth::user()->status == "0") {
            $data = $data->where('durable_articles_requisitions.id_user', Auth::user()->id);
        }


       $data = $data->orderBy('durable_articles_requisitions.id','DESC')->paginate(100);

        return view("durable_articles_requisition.index",['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $group = DB::table('categories')
        ->where('category_id', '=', 2)->orderBy('id', 'ASC')->get();
        return view("durable_articles_requisition.create",['group' =>  $group]);
    }

    public function durableRequisition($id) {


        $data = DB::table('durable_articles')->where('group_id',$id)->get();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = new DurableArticlesRequisition;
        $data->id_user = Auth::user()->id;
        $data->group_id = $request['group_id'];
        $data->code_durable_articles = $request['code_durable_articles'];
        $data->durable_articles_name = $request['durable_articles_name'];
        $data->amount_withdraw = $request['amount_withdraw'];
        $data->name_durable_articles_count = $request['name_durable_articles_count'];
        $data->statusApproval = "0";
        $data->status = "on";
        $data->save();



        $withdraw =  $request['amount_withdraw'];
        $remaining = $request['remaining_amount'];

      $amount =  $remaining - $withdraw;

      DurableArticles::where('id', $request['durable_articles_name'])->update([
            'remaining_amount' =>  $amount,
        ]);

        return redirect('durable-articles-requisition-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


        $data = DB::table('durable_articles_requisitions')
        ->where('durable_articles_requisitions.id', $id)
        ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('durable_articles', 'durable_articles_requisitions.durable_articles_name', '=', 'durable_articles.id')
        ->leftJoin('categories', 'durable_articles_requisitions.group_id', '=', 'categories.id')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->select('durable_articles_requisitions.*', 'users.prefix', 'users.first_name','users.last_name','departments.department_name',
    'durable_articles.durableArticles_name','categories.category_name','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
    ->get();



        return view('durable_articles_requisition.show',['data' =>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $data = DB::table('durable_articles_requisitions')
        ->where('durable_articles_requisitions.id', $id)
        ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->leftJoin('durable_articles', 'durable_articles_requisitions.durable_articles_name', '=', 'durable_articles.id')
        ->leftJoin('categories', 'durable_articles_requisitions.group_id', '=', 'categories.id')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->select('durable_articles_requisitions.*', 'users.prefix', 'users.first_name','users.last_name',
    'durable_articles.durableArticles_name','durable_articles.remaining_amount','categories.category_name','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
    ->get();


        return view('durable_articles_requisition.edit',['data' =>$data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        $data = DurableArticlesRequisition::find($id);

        $amount = $data["amount_withdraw"] +  $request["remaining_amount"];
        $amount_wit =  $amount - $request["amount_withdraw"];

        DurableArticles::where('id', $data['durable_articles_name'])->update([
            'remaining_amount' =>  $amount_wit,
        ]);

        DurableArticlesRequisition::where('id', $id)->update([
            'amount_withdraw' =>  $request["amount_withdraw"],
        ]);

        return redirect('durable-articles-requisition-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data_requisition = DurableArticlesRequisition::find($id);
        $data = DurableArticles::find($data_requisition->durable_articles_name);


        DurableArticles::where('id', $data_requisition->durable_articles_name)->update([
            'remaining_amount' =>  $data->remaining_amount + $data_requisition->amount_withdraw,
        ]);
        DurableArticlesRequisition::where('id', $id)->update([
            'status' =>  "off",
        ]);
        return redirect('durable-articles-requisition-index')->with('message', "ยกเลิกสำเร็จ");
    }

    public function approvalUpdate()
    {
        $data = DB::table('durable_articles_requisitions')
        ->where('durable_articles_requisitions.status', "on")
        ->where('durable_articles_requisitions.statusApproval', "0")
        ->leftJoin('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->leftJoin('durable_articles', 'durable_articles_requisitions.durable_articles_name', '=', 'durable_articles.id')
        ->select('durable_articles_requisitions.*', 'durable_articles.durableArticles_name','users.prefix', 'users.first_name','users.last_name')
        ->orderBy('durable_articles_requisitions.id','DESC')->paginate(100);

        return view("durable_articles_requisition.updateApproval",['data' => $data]);
    }

    public function approved($id)
    {

        DurableArticlesRequisition::where('id', $id)->update([
            'statusApproval' =>  "1",
        ]);

        return redirect('approval-update')->with('message', "อนุมัติสำเร็จ");

    }
    public function notApproved(Request $request)
    {


        DurableArticlesRequisition::where('id', $request["id"])->update([
            'statusApproval' =>  "2",
            'commentApproval' =>  $request["commentApproval"],
        ]);

        return redirect('approval-update')->with('message', "ไม่อนุมัติสำเร็จ");

    }


    public function exportPDF(Request $request)
    {

        $data = DB::table('durable_articles_requisitions')
        ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->select('durable_articles_requisitions.*', 'users.prefix', 'users.first_name','users.last_name');
           if (Auth::user()->status == "0") {
               $data =  $data->where('id_user', Auth::user()->id);
           }


           $pdf = PDF::loadView('durable_articles_requisition.exportPDF',['data' =>  $data->get()]);
           $pdf->setPaper('a4');
           return $pdf->download('exportPDF.pdf');


    }





}
