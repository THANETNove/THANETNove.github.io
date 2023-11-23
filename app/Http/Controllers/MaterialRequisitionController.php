<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialRequisition;
use App\Models\Material;
use DB;
use Auth;


class MaterialRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('material_requisitions')
        ->join('users', 'material_requisitions.id_user', '=', 'users.id')
        ->select('material_requisitions.*', 'users.prefix', 'users.first_name','users.last_name')
        ->orderBy('id','DESC')->paginate(100);
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

                $query->where('group_class', 'LIKE', "%$components[0]%")
                    ->where('type_durableArticles', 'LIKE', "%$components[1]%")
                    ->where('description', 'LIKE', "%$components[2]%");
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
