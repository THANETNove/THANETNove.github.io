<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Buy;
use App\Models\Material;
use App\Models\DurableArticles;
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


    public function categories($id)
    {
        $data = DB::table('categories')
        ->where('category_id', '=', $id)
        ->orderBy('id', 'ASC')
        ->get();

        return response()->json($data);
    }

    public function categoriesData($id)
    {

        $cate = DB::table('categories')
        ->where('id', '=', $id)
        ->orderBy('id', 'ASC')
        ->get();

        if ($cate[0]->category_id == 1) {
            $data = DB::table('materials')
            ->where('group_id', '=', $id)
            ->orderBy('id', 'ASC')
            ->get();
        }else{
            $data = DB::table('durable_articles')
            ->where('group_id', '=', $id)
            ->orderBy('id', 'ASC')
            ->get();
        }


        return response()->json($data);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'string', 'max:255'],
        ]);



        if ($request['type'] == 1) {
            $mate = DB::table('materials')
            ->where("code_material",'=',$request['categories_id'])
            ->orderBy('id', 'ASC')
            ->get();

            $number = $request['quantity'] + $mate[0]->material_number;

            $mat =  Material::find($mate[0]->id);
            $mat->material_number =  $number;
            $mat->save();


        }else{

            $parts = explode('-', $request['categories_id']);

            $dura = DB::table('durable_articles')
            ->where("group_class",'=',  $parts[0])
            ->where("type_durableArticles",'=', $parts[1])
            ->where("description",'=', $parts[2])
            ->orderBy('id', 'ASC')
            ->get();

            $number = $request['quantity'] + $dura[0]->durableArticles_number;
            $dur =  DurableArticles::find($dura[0]->id);
            $dur->durableArticles_number =  $number;
            $dur->save();
        }


        $data = new Buy;
        $data->typeBuy = $request['type'];
        $data->group_id = $request['group_id'];
        $data->buy_name = $request['buy_name'];
        $data->code_buy = $request['categories_id'];
        $data->quantity =  $request['quantity'];
        $data->counting_unit = $request['counting_unit'];
        $data->price_per_piece = $request['price_per_piece'];
        $data->total_price = $request['total_price'];
        $data->details = $request['details'];
        $data->date_enter = $request['date_enter'];
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
