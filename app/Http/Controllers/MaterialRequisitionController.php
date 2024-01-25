<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialRequisition;
use App\Models\Material;
use DB;
use Auth;
use PDF;


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
        ->select('material_requisitions.*', 'users.prefix', 'users.first_name','users.last_name',
        'materials.material_name as name','categories.category_name','storage_locations.building_name','storage_locations.floor','storage_locations.room_name');
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
       $data = $data->orderBy('material_requisitions.id','DESC')->paginate(100);

        return view('material_requisition.index',['data' =>$data]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = DB::table('materials')->get();
        $group = DB::table('categories')
        ->where('category_id', '=', 1)->orderBy('id', 'ASC')->get();


        return view('material_requisition.create',['data' =>$data ,'group' => $group]);
    }


    public function groupMaterial($id)
    {

       $data = DB::table('materials')->where('group_id',$id)->get();

        return response()->json($data);
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

        ]);

        $withdraw =  $request['amount_withdraw'];
        $remaining = $request['remaining_amount'];

      $amount =  $remaining - $withdraw;

      Material::where('id', $request['material_name'])->update([
            'remaining_amount' =>  $amount,
        ]);

        return redirect('material-requisition-index')->with('message', "บันทึกสำเร็จ");


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
        $data =   DB::table('material_requisitions')
        ->where('material_requisitions.id', $id)
        ->join('materials', 'material_requisitions.material_name', '=', 'materials.id')
        ->leftJoin('categories', 'material_requisitions.id_group', '=', 'categories.id')
        ->select('material_requisitions.*', 'materials.remaining_amount' ,'materials.material_name as name','categories.category_name')
        ->get();



        return view('material_requisition.edit',['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = MaterialRequisition::find($id);

        $amount = ($data["amount_withdraw"] +  $request["remaining_amount"])- $request["amount_withdraw"];


        Material::where('id', $request['id_name'])->update([
            'remaining_amount' =>  $amount,
        ]);

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
        $matReq= MaterialRequisition::find($id);
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

    public function exportPDF()
    {
        $currentYear = date('Y');

        $data = DB::table('material_requisitions')
        ->whereYear('material_requisitions.created_at', $currentYear)
        ->leftJoin('users', 'material_requisitions.id_user', '=', 'users.id')
       ->leftJoin('materials', 'material_requisitions.material_name', '=', 'materials.id')
         ->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
        ->leftJoin('categories', 'material_requisitions.id_group', '=', 'categories.id')
        ->where('material_requisitions.status', "on")
        ->select('material_requisitions.*', 'users.prefix', 'users.first_name','users.last_name',
        'materials.material_name as name','categories.category_name','storage_locations.building_name','storage_locations.floor','storage_locations.room_name');
        if (Auth::user()->status == "0") {
            $data =  $data->where('id_user', Auth::user()->id);
        }

        $pdf = PDF::loadView('material_requisition.exportPDF',['data' =>  $data->get(),'currentYear' => $currentYear]);
        $pdf->setPaper('a4');
        return $pdf->stream('exportPDF.pdf');

    }
}
