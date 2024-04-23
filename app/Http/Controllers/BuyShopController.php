<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuyShop;
use DB;


class BuyShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $group = DB::table('categories')
        ->where('category_id', '=', 1)->orderBy('id', 'DESC')->get();

        $data = DB::table('materials')->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
        ->leftJoin('categories', 'materials.group_id', '=', 'categories.id')
        ->join('buy_shops', 'materials.id', '=', 'buy_shops.buy_id')
        ->select('materials.*', 'categories.category_name','storage_locations.building_name',
        'storage_locations.floor','storage_locations.room_name','buy_shops.status_buy','buy_shops.required_quantity')
        ->paginate(100);
        return view('buy_shop.index',['data' => $data,'group' => $group ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //


        $data = new BuyShop;

        $data->buy_id = $request['buy_id'];
        $data->status_buy = "0";
        $data->required_quantity = $request['required_quantity'];
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
