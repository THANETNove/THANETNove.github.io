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
        ->join('users', 'material_requisitions.id_user', '=', 'users.id')
        ->select('material_requisitions.*', 'users.prefix', 'users.first_name','users.last_name');
       if ($search) {
        $data
        ->where('code_requisition', 'LIKE', "%$search%")
        ->orWhere('material_name', 'LIKE', "%$search%")
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

       $data = $data->orderBy('material_requisitions.id','DESC')->paginate(100);

        return view('material_requisition.index',['data' =>$data]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = DB::table('materials')->get();


        return view('material_requisition.create',['data' =>$data ]);
    }


    public function dataSelect($id)
    {

       $data = DB::table('materials');
        $data = $data->where(function ($query) use ($id) {

            $components = explode('-', $id);

            $components = explode('-', $id);
                if (count($components) == 3) {
                    // Full value like "7115-005-0003"

                    $query->where('group_class', 'LIKE', "%$components[0]%")
                        ->where('type_durableArticles', 'LIKE', "%$components[1]%")
                        ->where('description', 'LIKE', "%$components[2]%")
                        ->orWhere('material_name', 'LIKE', "%$id%");
                } elseif (count($components) == 2) {
                    // Partial value like "715" or "005"
                    $query->where('group_class', 'LIKE', "%$components[0]%")
                        ->where('type_durableArticles', 'LIKE', "%$components[1]%")
                        ->orWhere('description', 'LIKE', "%$id%")
                        ->orWhere('material_name', 'LIKE', "%$id%");

                } elseif (count($components) == 1) {
                    // Partial value like "715" or "005"
                    $query->where('group_class', 'LIKE', "%$id%")
                        ->orWhere('type_durableArticles', 'LIKE', "%$id%")
                        ->orWhere('description', 'LIKE', "%$id%")
                        ->orWhere('material_name', 'LIKE', "%$id%");
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



        MaterialRequisition::create([
            'id_user' => Auth::user()->id,
            'material_id' => $request['material_id'],
            'code_requisition' => $request['code_requisition'],
            'material_name' => $request['material_name'],
            'amount_withdraw' => $request['amount_withdraw'],
            'name_material_count' => $request['name_material_count'],
            'status' => "on",

        ]);

        $withdraw =  $request['amount_withdraw'];
        $remaining = $request['remaining_amount'];

      $amount =  $remaining - $withdraw;

      Material::where('id', $request['material_id'])->update([
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
        ->join('materials', 'material_requisitions.material_id', '=', 'materials.id')
        ->select('material_requisitions.*', 'materials.remaining_amount')
        ->get();

        return view('material_requisition.edit',['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = MaterialRequisition::find($id);

        $amount = $data["amount_withdraw"] +  $request["remaining_amount"];
        $amount_wit =  $amount - $request["amount_withdraw"];

        Material::where('id', $data['material_id'])->update([
            'remaining_amount' =>  $amount_wit,
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
        $mat = Material::find($matReq["material_id"]);

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

     $data = DB::table('material_requisitions')
     ->join('users', 'material_requisitions.id_user', '=', 'users.id')
     ->select('material_requisitions.*', 'users.prefix', 'users.first_name','users.last_name');
        if (Auth::user()->status == "0") {
            $data =  $data->where('id_user', Auth::user()->id);
        }





        $pdf = PDF::loadView('material_requisition.exportPDF',['data' =>  $data->get()]);
        $pdf->setPaper('a4');
        return $pdf->download('exportPDF.pdf');

    }
}