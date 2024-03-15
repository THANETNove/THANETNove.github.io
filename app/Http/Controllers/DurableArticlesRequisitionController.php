<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DurableArticlesRequisition;
use App\Models\DurableArticles;
use App\Models\Buy;
use DB;
use Auth;
use PDF;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
        ->leftJoin('durable_articles', 'durable_articles_requisitions.group_id', '=', 'durable_articles.id')
         ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
        ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->select('durable_articles_requisitions.*','type_categories.type_name', 'type_categories.type_code','users.prefix', 'users.first_name','users.last_name','departments.department_name',
    'durable_articles.durableArticles_name','durable_articles.description','durable_articles.warranty_period','categories.category_name','categories.category_code','storage_locations.building_name','storage_locations.floor','storage_locations.room_name');



       if ($search) {
        $data =  $data
            ->where(function ($query) use ($search) {
                $query->where('categories.category_name', 'LIKE', "%$search%")
                    ->orWhere('durable_articles.durableArticles_name', 'LIKE', "%$search%")
                    ->orWhere('users.first_name', 'LIKE', "%$search%")
                    ->orWhere('type_categories.type_name', 'LIKE', "%$search%")
                    ->orWhere('users.last_name', 'LIKE', "%$search%");
            });
        }

       if (Auth::user()->status == "0") {
            $data = $data->where('durable_articles_requisitions.id_user', Auth::user()->id);
        }


       $data = $data->orderBy('durable_articles_requisitions.id','DESC')
       ->groupBy('durable_articles_requisitions.group_withdraw')
       ->selectRaw('count(durable_articles_requisitions.group_withdraw) as groupWithdrawCount')
       ->paginate(100);

       $department = DB::table('departments')
       ->orderBy('department_name','ASC')
       ->get();


        return view("durable_articles_requisition.index",['data' => $data, 'department' => $department]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $group = DB::table('categories')
        ->where('category_id', '=', 2)->orderBy('id', 'ASC')->get();
        $name_type = "เบิกครุภัณฑ์";


        return view("durable_articles_requisition.create",['group' =>  $group,'name_type' => $name_type]);
    }
    public function createLend()
    {
        $group = DB::table('categories')
        ->where('category_id', '=', 2)->orderBy('id', 'ASC')->get();

        $name_type = "ยืมครุภัณฑ์";
        return view("durable_articles_requisition.create",['group' =>  $group, 'name_type' => $name_type]);
    }

    public function typeCategories($id) {


        $data = DB::table('type_categories')
        ->orderBy('type_name','ASC')
        ->where('type_id',$id)
        ->get();
        return response()->json($data);
    }


    public function durableRequisition($id) {


        $data = DB::table('durable_articles')
        ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
        ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->select('durable_articles.*','categories.category_code','type_categories.type_code')
        ->orderBy('durable_articles.durableArticles_name','ASC')
        ->where('type_durableArticles',$id)
        ->where('durable_articles.durableArticles_number',1)
        ->where('durable_articles.remaining_amount',1)
        ->orderBy('durable_articles.durableArticles_name','ASC')
        ->selectRaw('sum(durable_articles.remaining_amount = 1) as remainingAmountCount')
        ->groupBy('durable_articles.code_DurableArticles')
        ->get();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $dur_a = DB::table('durable_articles')
        ->where("code_DurableArticles",$request->durable_articles_id)
        ->where("remaining_amount",1);
        $dur_array = $dur_a->get();
        $dur_count = $dur_a->count();
        $random = "grp_wd" . Str::random(10);


        for ($i = 0; $i < $dur_count ; $i++) {

            if ($i < $request->amount_withdraw) {
                $data = new DurableArticlesRequisition;
                $data->id_user = Auth::user()->id;
                $data->group_id = $dur_array[$i]->id;
                $data->code_durable_articles = $request['code_durable_articles'] . '-' . $dur_array[$i]->group_count;
                $data->durable_articles_id = $request['durable_articles_id'];
                $data->group_withdraw = $random;
                $data->amount_withdraw = 1;
                $data->name_type = $request['name_type'];
                $data->name_durable_articles_count = $request['name_durable_articles_count'];
                $data->statusApproval = "0";
                $data->status = "0";
                $data->save();

                DurableArticles::where('id', $dur_array[$i]->id)->update([
                    'remaining_amount' => "0",
                ]);
            }
        }


        return redirect('durable-articles-requisition-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


        $dataId = DB::table('durable_articles_requisitions')
        ->where('durable_articles_requisitions.id', $id)
        ->get();

    $data = DB::table('durable_articles_requisitions')
    ->where('durable_articles_requisitions.group_withdraw', $dataId[0]->group_withdraw)
    ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
    ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
    ->leftJoin('durable_articles', 'durable_articles_requisitions.group_id', '=', 'durable_articles.id')
    ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
    ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
    ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
    ->select('durable_articles_requisitions.*','type_categories.type_name','type_categories.type_code', 'users.prefix', 'users.first_name','users.last_name','departments.department_name',
    'durable_articles.durableArticles_name','durable_articles.warranty_period','durable_articles.description','durable_articles.group_count','durable_articles.durableArticles_number','categories.category_name','categories.category_code','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
    ->get();




    return view('durable_articles_requisition.show',['data' =>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $dataId = DB::table('durable_articles_requisitions')
        ->where('durable_articles_requisitions.id', $id)
        ->get();
        $data = DB::table('durable_articles_requisitions')
        ->where('durable_articles_requisitions.group_withdraw', $dataId[0]->group_withdraw)
        ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('durable_articles', 'durable_articles_requisitions.group_id', '=', 'durable_articles.id')
        ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
        ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->selectRaw('count(durable_articles_requisitions.group_withdraw) as groupWithdrawCount,
        durable_articles_requisitions.*,
        type_categories.type_name,
        type_categories.type_code,
        users.prefix,
        users.first_name,
        users.last_name,
        departments.department_name,
        durable_articles.durableArticles_name,
        durable_articles.warranty_period,
        durable_articles.description,
        durable_articles.remaining_amount,
        durable_articles.group_count,
        durable_articles.durableArticles_number,
        categories.category_name,
        categories.category_code,
        storage_locations.building_name,
        storage_locations.floor,
        storage_locations.room_name')
        ->get();


        $countData = DB::table('durable_articles')
        ->where('code_DurableArticles', $dataId[0]->durable_articles_id)
        ->where('remaining_amount', 1)
        ->count();



        return view('durable_articles_requisition.edit',['data' =>$data,'countData' => $countData]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data = DurableArticlesRequisition::find($id);


        $dataRequisitions = DB::table('durable_articles_requisitions')
        ->where('durable_articles_requisitions.group_withdraw', $data->group_withdraw)
        ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('durable_articles', 'durable_articles_requisitions.group_id', '=', 'durable_articles.id')
        ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
        ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->select('durable_articles_requisitions.*','type_categories.type_name','type_categories.type_code', 'users.prefix', 'users.first_name','users.last_name','departments.department_name',
        'durable_articles.durableArticles_name','durable_articles.warranty_period','durable_articles.description','durable_articles.group_count','durable_articles.durableArticles_number','categories.category_name','categories.category_code','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
        ->orderBy('durable_articles_requisitions.id','DESC')
        ->get();

        if ( $request->amount_withdraw <  $request->previous_amount_withdraw) {// ลบค่าการเบิก

           $number =    $request->previous_amount_withdraw  - $request->amount_withdraw;
           for ($i = 0; $i < $number ; $i++) { //รับเข้าครั้งเเรก
            $requisition = DurableArticlesRequisition::find($dataRequisitions[$i]->id);
            $requisition->delete();
            DurableArticles::where('id', $dataRequisitions[$i]->group_id)->update([
                'remaining_amount' =>  1,
              ]);
            }

        }


        if ( $request->amount_withdraw > $request->previous_amount_withdraw  ) { //เพิ่มค่า การเบิก
            $number =  $request->amount_withdraw - $request->previous_amount_withdraw;
            $dataArticles= DB::table('durable_articles')
            ->where('code_DurableArticles',$dataRequisitions[0]->durable_articles_id)
            ->where('remaining_amount',1)
            ->orderBy('durable_articles.id','ASC')
            ->get();



            for ($i = 0; $i < $number ; $i++) {
                $data = new DurableArticlesRequisition;
                $data->id_user = $dataRequisitions[0]->id_user;
                $data->group_id = $dataArticles[$i]->id;
                $data->code_durable_articles = $request['code_durable_articles'] . '-' . $dataArticles[$i]->group_count;
                $data->durable_articles_id = $dataRequisitions[0]->durable_articles_id;
                $data->group_withdraw = $dataRequisitions[0]->group_withdraw;
                $data->amount_withdraw = 1;
                $data->name_type = $dataRequisitions[0]->name_type;
                $data->name_durable_articles_count = $request['name_durable_articles_count'];
                $data->statusApproval = "0";
                $data->status = "0";
                $data->save();

                DurableArticles::where('id',  $dataArticles[$i]->id)->update([
                    'remaining_amount' =>  0,
                  ]);
            }





        }

        return redirect('durable-articles-requisition-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = DurableArticlesRequisition::find($id);


        $dataRequisitions = DB::table('durable_articles_requisitions')
        ->where('durable_articles_requisitions.group_withdraw', $data->group_withdraw)
        ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('durable_articles', 'durable_articles_requisitions.group_id', '=', 'durable_articles.id')
        ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
        ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->select('durable_articles_requisitions.*','type_categories.type_name','type_categories.type_code', 'users.prefix', 'users.first_name','users.last_name','departments.department_name',
        'durable_articles.durableArticles_name','durable_articles.warranty_period','durable_articles.description','durable_articles.group_count','durable_articles.durableArticles_number','categories.category_name','categories.category_code','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
        ->orderBy('durable_articles_requisitions.id','DESC');

        $requisitions = $dataRequisitions->get();
        $number = $dataRequisitions->count();



           for ($i = 0; $i < $number ; $i++) {


            DurableArticles::where('id', $requisitions[$i]->group_id)->update([
                'remaining_amount' =>  1,
              ]);

            DurableArticlesRequisition::where('id', $requisitions[$i]->id)->update([
                'status' =>  1,
            ]);

            }

        return redirect('durable-articles-requisition-index')->with('message', "ยกเลิกสำเร็จ");
    }


    public function approvalUpdate()
    {
        $data = DB::table('durable_articles_requisitions')
        ->where('durable_articles_requisitions.status', "0")
        ->where('durable_articles_requisitions.statusApproval', "0")
        ->leftJoin('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->leftJoin('durable_articles', 'durable_articles_requisitions.group_id', '=', 'durable_articles.id')
        ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
       ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->select('durable_articles_requisitions.*','categories.category_name','type_categories.type_name',
         'durable_articles.durableArticles_name','users.prefix', 'users.first_name',
         'users.last_name')
         ->selectRaw('count(durable_articles_requisitions.group_withdraw) as groupWithdrawCount')
         ->orderBy('durable_articles_requisitions.id','DESC')->paginate(100);

        return view("durable_articles_requisition.updateApproval",['data' => $data]);
    }

    public function approved($id)
    {


        $data = DurableArticlesRequisition::find($id);


        $dataRequisitions = DB::table('durable_articles_requisitions')
        ->where('durable_articles_requisitions.group_withdraw', $data->group_withdraw)
        ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('durable_articles', 'durable_articles_requisitions.group_id', '=', 'durable_articles.id')
        ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
        ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->select('durable_articles_requisitions.*','type_categories.type_name','type_categories.type_code', 'users.prefix', 'users.first_name','users.last_name','departments.department_name',
        'durable_articles.durableArticles_name','durable_articles.warranty_period','durable_articles.description','durable_articles.group_count','durable_articles.durableArticles_number','categories.category_name','categories.category_code','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
        ->orderBy('durable_articles_requisitions.id','DESC');

        $requisitions = $dataRequisitions->get();
        $number = $dataRequisitions->count();

           for ($i = 0; $i < $number ; $i++) {

            DurableArticlesRequisition::where('id', $requisitions[$i]->id)->update([
                'statusApproval' =>  1,
            ]);

            }

        return redirect('approval-update')->with('message', "อนุมัติสำเร็จ");

    }
    public function notApproved(Request $request)
    {


        $data = DurableArticlesRequisition::find($request["id"]);


        $dataRequisitions = DB::table('durable_articles_requisitions')
        ->where('durable_articles_requisitions.group_withdraw', $data->group_withdraw)
        ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('durable_articles', 'durable_articles_requisitions.group_id', '=', 'durable_articles.id')
        ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
        ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->select('durable_articles_requisitions.*','type_categories.type_name','type_categories.type_code', 'users.prefix', 'users.first_name','users.last_name','departments.department_name',
        'durable_articles.durableArticles_name','durable_articles.warranty_period','durable_articles.description','durable_articles.group_count','durable_articles.durableArticles_number','categories.category_name','categories.category_code','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
        ->orderBy('durable_articles_requisitions.id','DESC');

        $requisitions = $dataRequisitions->get();

        $number = $dataRequisitions->count();



           for ($i = 0; $i < $number ; $i++) {


            DurableArticles::where('id', $requisitions[$i]->group_id)->update([
                'remaining_amount' =>  1,
              ]);

            DurableArticlesRequisition::where('id',  $requisitions[$i]->id)->update([
                'statusApproval' =>  "2",
                'commentApproval' =>  $request["commentApproval"],
            ]);

            }
        return redirect('approval-update')->with('message', "ไม่อนุมัติ สำเร็จ");

    }


    public function exportPDF(Request $request)
    {

        $start_date = $request["start_date"];
        $end_date = $request["end_date"];
        $end_date = Carbon::parse($end_date)->endOfDay()->toDateTimeString();
        $currentYear =  Carbon::parse($start_date)->year;


        $currentYear = date('Y');
        $data = DB::table('durable_articles_requisitions')
        ->whereBetween('durable_articles_requisitions.created_at', [$start_date, $end_date]) // Add t
        ->where('durable_articles_requisitions.statusApproval', 1) // Add t
        ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('durable_articles', 'durable_articles_requisitions.durable_articles_name', '=', 'durable_articles.id')
        ->leftJoin('categories', 'durable_articles_requisitions.group_id', '=', 'categories.id')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->select('durable_articles_requisitions.*', 'users.prefix', 'users.first_name','users.last_name','departments.department_name',
        'durable_articles.durableArticles_name', 'departments.department_name','categories.category_name','storage_locations.building_name','storage_locations.floor','storage_locations.room_name');

        if (Auth::user()->status == "0") {
               $data =  $data->where('id_user', Auth::user()->id);
           }

           if ($request["dep_name"] != "all" && $request["dep_name"] != null) {
            $data =  $data->where('departments.id', $request["dep_name"]);
             }




           $pdf = PDF::loadView('durable_articles_requisition.exportPDF',['data' =>  $data->get(),'currentYear' => $currentYear]);
           $pdf->setPaper('a4');
           return $pdf->stream('exportPDF.pdf');


    }





}