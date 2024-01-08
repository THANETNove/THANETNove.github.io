<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use DB;

class CategoryController extends Controller
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
        $data = DB::table('categories')->orderBy('id', 'DESC');
        if ($search && $search != 3) {
            $data =  $data->where('category_id', 'LIKE', "%$search%")
            ->paginate(100);
            $id_search = $search;
        }else{
            $data =  $data
            ->paginate(100);
            $id_search = 3;
        }

        return view('category.index',['data' => $data,"id_search" => $id_search]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = new Category;

        $data->category_id = $request['category_id'];
        $data->category_name = $request['category_name'];
        $data->save();

        return redirect('category-index')->with('message', "บันทึกสำเร็จ");
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
        $data =  Category::find($id);
        return view('category.edit',['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data =  Category::find($id);
        $data->category_id = $request['category_id'];
        $data->category_name = $request['category_name'];
        $data->save();
     return redirect('category-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
