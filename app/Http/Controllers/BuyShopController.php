<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuyShop;
use App\Models\Material;
use App\Models\Buy;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class BuyShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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
            ->select(
                'materials.*',
                'categories.category_name',
                'storage_locations.building_name',
                'storage_locations.floor',
                'storage_locations.room_name',
                'buy_shops.status_buy',
                'buy_shops.required_quantity',
                'buy_shops.id as buy_id'
            )
            ->where('status_buy', '=', 0)
            ->paginate(100);
        return view('buy_shop.index', ['data' => $data, 'group' => $group]);
    }

    public function indexAdd(Request $request)
    {


        $group = DB::table('categories')
            ->where('category_id', '=', 1)->orderBy('id', 'DESC')->get();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $data = DB::table('materials')->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
            ->leftJoin('categories', 'materials.group_id', '=', 'categories.id')
            ->join('buy_shops', 'materials.id', '=', 'buy_shops.buy_id')
            ->select(
                'materials.*',
                'categories.category_name',
                'storage_locations.building_name',
                'storage_locations.floor',
                'storage_locations.room_name',
                'buy_shops.status_buy',
                'buy_shops.required_quantity',
                'buy_shops.id as buy_id',
                'buy_shops.updated_at AS updated_buy'
            );




        if ($request->start_date || $request->end_date) {
            $data =    $data->whereBetween('material_requisitions.created_at', [$request->start_date, $request->$end_date]);
        } else {
            $data =   $data->whereYear('buy_shops.updated_at', $currentYear)
                ->whereMonth('buy_shops.updated_at', $currentMonth);
        }

        $data =   $data->where('status_buy', '>', 0)
            ->paginate(500);

        return view('buy_shop.buyAdd', ['data' => $data, 'group' => $group]);
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
    public function update(Request $request)
    {


        $data =  BuyShop::find($request['buy_id']);

        $data->status_buy = "1";
        $data->amount_received = $request['amount_received'];
        $data->save();



        $dataMaterial =  Material::find($data['buy_id']);
        $dataMaterial->material_number = $dataMaterial->material_number + $request['amount_received'];
        $dataMaterial->remaining_amount = $dataMaterial->remaining_amount + $request['amount_received'];
        $dataMaterial->save();


        $dataBuy =  new Buy;
        $dataBuy->code_buy = $data['buy_id'];
        $dataBuy->price_per_piece = $request['price'];
        $dataBuy->total_price = $request['total_price'];
        $dataBuy->quantity = $request['amount_received'];
        $dataBuy->save();
        return redirect('buy-shop')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {


        $data =  BuyShop::find($id);
        $data->status_buy = "2";
        $data->save();
        return redirect('buy-shop')->with('message', "บันทึกสำเร็จ");
    }
}
