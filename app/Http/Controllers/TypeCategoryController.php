<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TypeCategory;

class TypeCategoryController extends Controller


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
        $data = DB::table('type_categories')
            ->leftJoin('categories', 'type_categories.type_id', '=', 'categories.id')
            ->select('type_categories.*', 'categories.category_name')
            ->orderBy('categories.category_name', 'ASC')
            ->orderBy('type_categories.type_name', 'ASC');
        if ($search) {
            $data =  $data->where('categories.category_name', 'LIKE', "%$search%")
                ->orWhere('type_categories.type_name', 'LIKE', "%$search%")
                ->paginate(100);
        } else {
            $data =  $data
                ->paginate(100);
        }

        return view('type_category.index', ['data' => $data,]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $group = DB::table('categories')
            ->where('category_id', 2)
            ->get();

        return view("type_category.create", ['group' => $group]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new TypeCategory;

        $data->type_id = $request['type_id'];
        $data->type_code = $request['type_code'];
        $data->type_name = $request['type_name'];
        $data->save();

        return redirect('typeCategory-index')->with('message', "บันทึกสำเร็จ");
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
        $group = DB::table('categories')
            ->where('category_id', 2)
            ->get();

        $data =  TypeCategory::find($id);
        return view('type_category.edit', ['data' => $data, "group" => $group]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data =  TypeCategory::find($id);

        $data->type_id = $request['type_id'];
        $data->type_code = $request['type_code'];
        $data->type_name = $request['type_name'];
        $data->save();

        return redirect('typeCategory-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
