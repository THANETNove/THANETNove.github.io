<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use App\Models\Material;



class MaterialController extends Controller
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
        $data = DB::table('materials')->join('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage');

        if ($search) {
            $data = $data->where(function ($query) use ($search) {
                $components = explode('-', $search);

                if (count($components) == 3) {
                    // Full value like "7115-005-0003"
                    $query->where('group_class', 'LIKE', "%$components[0]%")
                        ->where('type_durableArticles', 'LIKE', "%$components[1]%")
                        ->where('description', 'LIKE', "%$components[2]%")
                        ->orWhere('material_name', 'LIKE', "%$search%");
                } elseif (count($components) == 2) {
                    // Partial value like "715" or "005"
                    $query->where('group_class', 'LIKE', "%$components[0]%")
                        ->where('type_durableArticles', 'LIKE', "%$components[1]%")
                        ->orWhere('description', 'LIKE', "%$search%")
                        ->orWhere('material_name', 'LIKE', "%$search%");

                } elseif (count($components) == 1) {
                    // Partial value like "715" or "005"
                    $query->where('group_class', 'LIKE', "%$search%")
                        ->orWhere('type_durableArticles', 'LIKE', "%$search%")
                        ->orWhere('description', 'LIKE', "%$search%")
                        ->orWhere('material_name', 'LIKE', "%$search%");
                }
                // Add additional conditions for other cases if needed
            })
            ->orderBy('materials.id', 'DESC')
            ->paginate(100);


        }else{
            $data = $data
            ->orderBy('materials.id','DESC')->paginate(100);
        }
        return view('material.index',['data' => $data ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = DB::table('storage_locations')->where('status','on')->get();
        return view('material.create',['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $random = "mate-" . Str::random(10);

        $data = new Material;
        $data->code_material = $random;
        $data->group_class = $request['group_class'];
        $data->type_durableArticles = $request['type_durableArticles'];
        $data->description = $request['description'];
        $data->material_name = $request['material_name'];
        $data->material_number = $request['material_number'];
        $data->remaining_amount = $request['material_number'];
        /* $data->material_number_pack_dozen = $request['material_number_pack_dozen']; */
        $data->name_material_count = $request['name_material_count'];
        $data->code_material_storage = $request['code_material_storage'];
        $data->status = "on";
        $data->save();

        return redirect('material-index')->with('message', "บันทึกสำเร็จ");


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

        $mate =  Material::find($id);
        $data = DB::table('storage_locations')->where('status','on')->get();
        return view('material.edit',['mate' => $mate ,'data' =>   $data ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data =  Material::find($id);
        $data->group_class = $request['group_class'];
        $data->type_durableArticles = $request['type_durableArticles'];
        $data->description = $request['description'];
        $data->material_name = $request['material_name'];
        $data->material_number = $request['material_number'];
       /*  $data->material_number_pack_dozen = $request['material_number_pack_dozen']; */
        $data->name_material_count = $request['name_material_count'];
        $data->code_material_storage = $request['code_material_storage'];
        $data->save();

        return redirect('material-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
