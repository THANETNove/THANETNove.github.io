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


        $data = DB::table('materials')
            ->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
            ->join('buy_shops', 'materials.id', '=', 'buy_shops.buy_id')
            ->leftJoin('categories', 'materials.group_id', '=', 'categories.id')
            ->select(
                'materials.*',
                'buy_shops.required_quantity',
                'buy_shops.amount_received',
                'categories.category_name',
                'storage_locations.building_name',
                'storage_locations.floor',
                'storage_locations.room_name',
                'buy_shops.status_buy',
                'buy_shops.id AS id_shop',
                'buy_shops.created_at AS created_at_shop',
                DB::raw('SUM(buy_shops.required_quantity) as total_required_quantity'),
                DB::raw('SUM(buy_shops.amount_received) as total_amount_received')
            )
            ->groupBy('materials.code_material')
            ->where('buy_shops.status_buy', '=', 0)
            ->paginate(100);


        return view('buy_shop.index', ['data' => $data, 'group' => $group]);
    }

    public function indexAdd(Request $request)
    {


        $group = DB::table('categories')
            ->where('category_id', '=', 1)->orderBy('id', 'DESC')->get();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $data = DB::table('materials')
            ->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
            ->join('buy_shops', 'materials.id', '=', 'buy_shops.buy_id')
            ->leftJoin('categories', 'materials.group_id', '=', 'categories.id')
            ->select(
                'materials.*',
                'buy_shops.required_quantity',
                'buy_shops.amount_received',
                'categories.category_name',
                'storage_locations.building_name',
                'storage_locations.floor',
                'storage_locations.room_name',
                'buy_shops.status_buy',
                'buy_shops.created_at AS created_at_shop',
                DB::raw('SUM(buy_shops.required_quantity) as total_required_quantity'),
                DB::raw('SUM(buy_shops.amount_received) as total_amount_received')
            )
            ->where('buy_shops.status_buy', '>', 0)
            ->groupBy('materials.code_material');




        if ($request->start_date || $request->end_date) {
            $data =    $data->whereBetween('buy_shops.created_at', [$request->start_date, $request->end_date]);
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

        /*  dd($dataId); */
        /*  dd($dataId[0]->code_material, $request->all(), $request['buy_id']); */
        $data2 = DB::table('buy_shops')
            ->where('buy_id', $request['id'])
            ->get();
        $amountReceived = $request['amount_received'];

        foreach ($data2 as $var) {
            $data = BuyShop::find($var->id);

            if ($amountReceived >= $data->required_quantity) {
                // Subtract the required_quantity from amountReceived and set amount_received
                $amountReceived -= $data->required_quantity;
                $data->amount_received = $data->required_quantity;
                $data->status_buy = "1";
            } elseif ($amountReceived > 0) {
                // Set the remaining amountReceived as amount_received
                $data->amount_received = $amountReceived;
                $data->status_buy = "1";
                $amountReceived = 0; // All the amount is allocated
            }

            $data->save();

            // Break the loop if all amount is allocated
            if ($amountReceived <= 0) {
                break;
            }
        }

        // If there's remaining amountReceived after the loop, update the last item with the remaining amount
        if ($amountReceived > 0 && isset($data)) {
            $data->amount_received += $amountReceived;
            $data->save();
        }




        $dataMaterial =  Material::find($request['id']);
        $dataMaterial->material_number = $dataMaterial->material_number + $request['amount_received'];
        $dataMaterial->remaining_amount = $dataMaterial->remaining_amount + $request['amount_received'];
        $dataMaterial->save();


        $dataBuy =  new Buy;
        $dataBuy->code_buy = $request['id'];
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
