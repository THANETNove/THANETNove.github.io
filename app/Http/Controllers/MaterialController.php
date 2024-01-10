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
        $group = DB::table('categories')
        ->where('category_id', '=', 1)->orderBy('id', 'DESC')->get();


        $search =  $request['search'];

        $data = DB::table('materials')->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
        ->leftJoin('categories', 'materials.group_id', '=', 'categories.id')
        ->select('materials.*', 'categories.category_name','storage_locations.building_name','storage_locations.floor','storage_locations.room_name');

        if ($search) {

            $data = $data->where(function ($query) use ($search) {
                $query->where('category_name', 'LIKE', "%$search%")
                ->orWhere('material_name', 'LIKE', "%$search%");
                // Add additional conditions for other cases if needed
            })
            ->orderBy('materials.id', 'DESC')
            ->paginate(100);


        }else{

            $data = $data
            ->orderBy('materials.id','DESC')->paginate(100);

        }
        return view('material.index',['data' => $data,'group' => $group ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $group = DB::table('categories')
        ->where('category_id', '=', 1)->orderBy('id', 'DESC')->get();


        $data = DB::table('storage_locations')->where('status','on')->get();
        return view('material.create',['data' => $data,'group' => $group]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       /*  $random = "mate-" . mt_rand(1000000000, 9999999999); */

       $counter = 1000000000; // Initial counter value

       $random = "mate-" . $counter;
       $latestId = DB::table('materials')->max('id');
       $counterId = "mate-" . $counter + $latestId;


        $data = new Material;
        $data->code_material = $latestId ? $counterId = "mate-" .$counter + $latestId :$random  ;        ;
        /* $data->group_class = $request['group_class'];
        $data->type_durableArticles = $request['type_durableArticles'];
        $data->description = $request['description']; */
        $data->material_name = $request['material_name'];
        $data->group_id = $request['group_id'];
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
        $group = DB::table('categories')
        ->where('category_id', '=', 1)->orderBy('id', 'DESC')->get();
        return view('material.edit',['mate' => $mate ,'data' =>   $data,'group'=> $group ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data =  Material::find($id);
        /* $data->group_class = $request['group_class'];
        $data->type_durableArticles = $request['type_durableArticles'];
        $data->description = $request['description']; */
        $data->material_name = $request['material_name'];
        $data->group_id = $request['group_id'];
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
