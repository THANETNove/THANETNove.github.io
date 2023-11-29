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
        $data = DB::table('durable_articles_requisitions')->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->select('durable_articles_requisitions.*', 'users.prefix', 'users.first_name','users.last_name');


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
        return view("durable_articles_requisition.create");
    }

    public function durableRequisition($id) {


        $data = DB::table('durable_articles');
        $data = $data->where(function ($query) use ($id) {

            $components = explode('-', $id);

            $components = explode('-', $id);
                if (count($components) == 3) {
                    // Full value like "7115-005-0003"

                    $query->where('group_class', 'LIKE', "%$components[0]%")
                        ->where('type_durableArticles', 'LIKE', "%$components[1]%")
                        ->where('description', 'LIKE', "%$components[2]%")
                        ->orWhere('durableArticles_name', 'LIKE', "%$id%");
                } elseif (count($components) == 2) {
                    // Partial value like "715" or "005"
                    $query->where('group_class', 'LIKE', "%$components[0]%")
                        ->where('type_durableArticles', 'LIKE', "%$components[1]%")
                        ->orWhere('description', 'LIKE', "%$id%")
                        ->orWhere('durableArticles_name', 'LIKE', "%$id%");

                } elseif (count($components) == 1) {
                    // Partial value like "715" or "005"
                    $query->where('group_class', 'LIKE', "%$id%")
                        ->orWhere('type_durableArticles', 'LIKE', "%$id%")
                        ->orWhere('description', 'LIKE', "%$id%")
                        ->orWhere('durableArticles_name', 'LIKE', "%$id%");
                }
            });
            $data = $data->get();


        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $data = new DurableArticlesRequisition;
        $data->id_user = Auth::user()->id;
        $data->durable_articles_id = $request['durable_articles_id'];
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

      DurableArticles::where('id', $request['durable_articles_id'])->update([
            'remaining_amount' =>  $amount,
        ]);

        return redirect('durable-articles-requisition-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data =   DB::table('durable_articles_requisitions')

        ->where('durable_articles_requisitions.id', $id)
        ->join('durable_articles', 'durable_articles_requisitions.durable_articles_id', '=', 'durable_articles.id')
        ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->select('durable_articles_requisitions.*', 'users.prefix', 'users.first_name','users.last_name')
        ->get();


        return view('durable_articles_requisition.show',['data' =>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data =   DB::table('durable_articles_requisitions')

        ->where('durable_articles_requisitions.id', $id)
        ->join('durable_articles', 'durable_articles_requisitions.durable_articles_id', '=', 'durable_articles.id')
        ->select('durable_articles_requisitions.*', 'durable_articles.remaining_amount')
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

        DurableArticles::where('id', $data['durable_articles_id'])->update([
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
        ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->select('durable_articles_requisitions.*', 'users.prefix', 'users.first_name','users.last_name')
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
