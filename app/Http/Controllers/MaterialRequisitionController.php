<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialRequisition;
use App\Models\Material;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;


class MaterialRequisitionController extends Controller
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
        $data = DB::table('material_requisitions')
            ->leftJoin('users', 'material_requisitions.id_user', '=', 'users.id')
            ->leftJoin('materials', 'material_requisitions.material_name', '=', 'materials.id')
            ->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
            ->leftJoin('categories', 'material_requisitions.id_group', '=', 'categories.id')
            ->select(
                'material_requisitions.*',
                'users.prefix',
                'users.first_name',
                'users.last_name',
                'materials.material_name as name',
                'categories.category_name',
                'storage_locations.building_name',
                'storage_locations.floor',
                'storage_locations.room_name',
                DB::raw('SUM(material_requisitions.amount_withdraw) as total_amount_withdraw')
            )
            ->groupBy('material_requisitions.id_user', 'material_requisitions.code_requisition', 'material_requisitions.status_approve');


        if ($search) {
            $data
                ->where('category_name', 'LIKE', "%$search%")
                ->orWhere('materials.material_name', 'LIKE', "%$search%")
                ->orWhere('users.first_name', 'LIKE', "%$search%")
                ->orWhere('users.last_name', 'LIKE', "%$search%");
        }
        if (Auth::user()->status == 0) {
            $data = $data->where('id_user', Auth::user()->id);
        }
        $data = $data->orderBy('material_requisitions.id', 'DESC')->paginate(100)->appends(['search' => $search]);

        $department = DB::table('departments')
            ->orderBy('department_name', 'ASC')
            ->get();
        return view('material_requisition.index', ['data' => $data, 'department' => $department]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = DB::table('materials')->get();
        $group = DB::table('categories')
            ->where('category_id', '=', 1)->orderBy('id', 'ASC')->get();


        return view('material_requisition.create', ['data' => $data, 'group' => $group]);
    }


    public function groupMaterial($id)
    {

        $data = DB::table('materials')->where('group_id', $id)->get();

        return response()->json($data);
    }

    public function approvalMaterial()
    {

        $data = DB::table('material_requisitions')
            ->leftJoin('users', 'material_requisitions.id_user', '=', 'users.id')
            ->leftJoin('materials', 'material_requisitions.material_name', '=', 'materials.id')
            ->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
            ->leftJoin('categories', 'material_requisitions.id_group', '=', 'categories.id')
            ->select(
                'material_requisitions.*',
                'users.prefix',
                'users.first_name',
                'users.last_name',
                'materials.material_name as name',
                'categories.category_name',
                'storage_locations.building_name',
                'storage_locations.floor',
                'storage_locations.room_name'
            )
            ->where('material_requisitions.status', '=', "on")
            ->where('material_requisitions.status_approve', "0")
            ->get();

        $department = DB::table('departments')
            ->orderBy('department_name', 'ASC')
            ->get();

        return view('material_requisition.approve', ['data' => $data, 'department' => $department]);
    }

    public function approved(Request $request)
    {

        $data = MaterialRequisition::find($request->id);
        $data2 = Material::find($data->material_name);

        if ($data2->remaining_amount == 0) {
            // return back()->with('remaining_amount_zero', 'วัสดุทั้งหมดเหลือ 0');
            return back()->withErrors(['remaining_amount_zero' => 'วัสดุทั้งหมดเหลือ 0']);
        }


        if ($request->withdrawCount > $data2->remaining_amount) {
            $amount = $data2->remaining_amount;
            $approvedNumber = $data2->remaining_amount;
        } else {
            $amount =  $data2->remaining_amount - $request->withdrawCount;
            $approvedNumber = $request->withdrawCount;
        }

        MaterialRequisition::where('id', $request->id)->update([
            'status_approve' =>  1,
            'amount_withdraw' =>  $approvedNumber,
        ]);

        Material::where('id', $data->material_name)->update([
            'remaining_amount' =>  $amount,
        ]);

        return redirect('approval-material-requisition')->with('message', "อนุมัติสำเร็จ");
    }
    public function notApproved(Request $request)
    {
        $matReq = MaterialRequisition::find($request->id);
        $mat = Material::find($matReq->material_name);



        MaterialRequisition::where('id', $request->id)->update([
            'status_approve' =>  2,
            'commentApproval' =>  $request->commentApproval,
        ]);
        Material::where('id', $matReq->material_name)->update([
            'remaining_amount' =>  $matReq->amount_withdraw + $mat->remaining_amount
        ]);

        return redirect('approval-material-requisition')->with('message', "ไม่อนุมัติ สำเร็จ");
    }
    public function approvalMaterialWaitingReceive(Request $request)
    {
        $data = DB::table('material_requisitions')
            ->leftJoin('users', 'material_requisitions.id_user', '=', 'users.id')
            ->leftJoin('materials', 'material_requisitions.material_name', '=', 'materials.id')
            ->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
            ->leftJoin('categories', 'material_requisitions.id_group', '=', 'categories.id')
            ->select(
                'material_requisitions.*',
                'users.prefix',
                'users.first_name',
                'users.last_name',
                'materials.material_name as name',
                'categories.category_name',
                'storage_locations.building_name',
                'storage_locations.floor',
                'storage_locations.room_name',
                DB::raw('SUM(material_requisitions.amount_withdraw) as total_amount_withdraw')
            )
            ->where('material_requisitions.status_approve', '1')
            ->where('material_requisitions.starts_waiting_receive', 'off')

            ->groupBy('material_requisitions.id_user', 'material_requisitions.code_requisition', 'material_requisitions.status_approve');


        if (Auth::user()->status == 0) {
            $data = $data->where('id_user', Auth::user()->id);
        }
        $data = $data->orderBy('material_requisitions.id', 'DESC')->paginate(100);

        $department = DB::table('departments')
            ->orderBy('department_name', 'ASC')
            ->get();
        return view('waiting_receive.material', ['data' => $data, 'department' => $department]);
    }
    public function materialWaitingReceive($id)
    {

        MaterialRequisition::where('id', $id)->update([
            'starts_waiting_receive' =>  "on",
        ]);
        return redirect('approval-material-waiting-receive')->with('message', "รับของเเล้ว");
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



        MaterialRequisition::create([
            'id_user' => Auth::user()->id,
            'id_group' => $request['id_group'],
            'code_requisition' => $request['code_requisition'],
            'material_name' => $request['material_name'],
            'amount_withdraw' => $request['amount_withdraw'],
            'name_material_count' => $request['name_material_count'],
            'status' => "on",
            'status_approve' => "0",
            'starts_waiting_receive' => "off"

        ]);

        /*   $withdraw =  $request['amount_withdraw'];
        $remaining = $request['remaining_amount'];

        $amount =  $remaining - $withdraw;

        Material::where('id', $request['material_name'])->update([
            'remaining_amount' =>  $amount,
        ]); */

        return redirect('material-requisition-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::table('material_requisitions')
            ->where('material_requisitions.id', $id)
            ->leftJoin('users', 'material_requisitions.id_user', '=', 'users.id')
            ->leftJoin('materials', 'material_requisitions.material_name', '=', 'materials.id')
            ->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
            ->leftJoin('categories', 'material_requisitions.id_group', '=', 'categories.id')
            ->select(
                'material_requisitions.*',
                'users.prefix',
                'users.first_name',
                'users.last_name',
                'materials.material_name as name',
                'categories.category_name',
                'storage_locations.building_name',
                'storage_locations.floor',
                'storage_locations.room_name'
            )
            ->get();

        return view('material_requisition.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data =   DB::table('material_requisitions')
            ->where('material_requisitions.id', $id)
            ->join('materials', 'material_requisitions.material_name', '=', 'materials.id')
            ->leftJoin('categories', 'material_requisitions.id_group', '=', 'categories.id')
            ->select('material_requisitions.*', 'materials.remaining_amount', 'materials.material_name as name', 'categories.category_name')
            ->get();



        return view('material_requisition.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = MaterialRequisition::find($id);

        $amount = ($data["amount_withdraw"] +  $request["remaining_amount"]) - $request["amount_withdraw"];

        /* 
        Material::where('id', $request['id_name'])->update([
            'remaining_amount' =>  $amount,
        ]);
 */
        MaterialRequisition::where('id', $id)->update([
            'amount_withdraw' =>  $request["amount_withdraw"],
        ]);

        return redirect('material-requisition-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $matReq = MaterialRequisition::find($id);
        $mat = Material::find($matReq["material_name"]);

        $amount = $matReq["amount_withdraw"] +  $mat["remaining_amount"];


        Material::where('id', $mat['id'])->update([
            'remaining_amount' =>  $amount,
        ]);

        MaterialRequisition::where('id', $matReq['id'])->update([
            'status' =>  "off",
        ]);

        return redirect('material-requisition-index')->with('message', "ยกเลิกสำเร็จ");
    }

    public function exportPDF(Request $request)
    {
        $start_date = $request["start_date"];
        $end_date = $request["end_date"];
        $end_date = Carbon::parse($end_date)->endOfDay()->toDateTimeString();
        $currentYear =  Carbon::parse($start_date)->year;




        $data = DB::table('material_requisitions')
            ->whereBetween('material_requisitions.created_at', [$start_date, $end_date]) // Add t
            ->leftJoin('users', 'material_requisitions.id_user', '=', 'users.id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('materials', 'material_requisitions.material_name', '=', 'materials.id')
            ->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
            ->leftJoin('categories', 'material_requisitions.id_group', '=', 'categories.id')
            ->where('material_requisitions.status', "on")
            ->select(
                'material_requisitions.*',
                'users.prefix',
                'users.first_name',
                'users.last_name',
                'materials.material_name as name',
                'departments.department_name',
                'categories.category_name',
                'storage_locations.building_name',
                'storage_locations.floor',
                'storage_locations.room_name'
            );
        if (Auth::user()->status == "0") {
            $data =  $data->where('id_user', Auth::user()->id);
        }
        if ($request["dep_name"] != "all" && $request["dep_name"] != null) {
            $data =  $data->where('departments.id', $request["dep_name"]);
        }


        $pdf = PDF::loadView('material_requisition.exportPDF', ['data' =>  $data->get(), 'currentYear' => $currentYear]);
        $pdf->setPaper('a4');
        return $pdf->stream('exportPDF.pdf');
    }
}
