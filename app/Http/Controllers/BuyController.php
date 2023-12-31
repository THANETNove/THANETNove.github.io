<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Buy;
use DB;
use PDF;

class BuyController extends Controller
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
        $data = DB::table('buys');

        if($search) {
            $data->orWhere('typeBuy', 'LIKE', "%$search%")
            ->orWhere('buy_name', 'LIKE', "%$search%");
        }
        $data = $data->orderBy('id', 'DESC')->paginate(100);

        return view('buy.index',['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buy.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'string', 'max:255'],
        ]);


        $random = "buy-" . Str::random(10);

        $data = new Buy;
        $data->code_buy = $random;
        $data->typeBuy = $request['typeBuy'];
        $data->buy_name = $request['buy_name'];
        $data->quantity = $request['quantity'];
        $data->counting_unit = $request['counting_unit'];
        $data->price_per_piece = $request['price_per_piece'];
        $data->total_price = $request['total_price'];
        $data->details = $request['details'];
        $data->status = "0";
        $data->save();

        return redirect('buy-index')->with('message', "บันทึกสำเร็จ");
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

        $buy =  Buy::find($id);

        return view('buy.edit',['buy' => $buy  ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data =  Buy::find($id);
        $data->typeBuy = $request['typeBuy'];
        $data->buy_name = $request['buy_name'];
        $data->quantity = $request['quantity'];
        $data->counting_unit = $request['counting_unit'];
        $data->price_per_piece = $request['price_per_piece'];
        $data->total_price = $request['total_price'];
        $data->details = $request['details'];
        $data->save();

        return redirect('buy-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data =  Buy::find($id);
        $data->status = "2";
        $data->save();

        return redirect('buy-index')->with('message', "ยกเลิกสำเร็จ");
    }
    public function statusBuy(string $id)
    {
        $data =  Buy::find($id);
        $data->status = "1";
        $data->save();

        return redirect('buy-index')->with('message', "ซื้อสำเร็จ");
    }

    public function exportPDF()
    {
         $data = DB::table('buys')->get();
        $pdf = PDF::loadView('buy.exportPDF',['data' =>  $data]);
        $pdf->setPaper('a4');
        return $pdf->download('exportPDF.pdf');

      /*   return view('storage_location.exportPDF',['data' => $data]); */
    }
}
