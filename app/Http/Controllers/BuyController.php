<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Buy;
use App\Models\Material;
use App\Models\DurableArticles;
use DB;
use PDF;
use Carbon\Carbon;


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
        $data = DB::table('buys')
        ->leftJoin('categories', 'buys.group_id', '=', 'categories.id')
        ->leftJoin('materials', 'buys.buy_name', '=', 'materials.id')
        ->leftJoin('durable_articles', 'buys.buy_name', '=', 'durable_articles.id')
        ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
        ->select('buys.*', 'categories.category_name' , 'materials.material_name', 'type_categories.type_name',
         'durable_articles.durableArticles_name');

        if($search) {
            $data->orWhere('categories.category_name', 'LIKE', "%$search%")
            ->orWhere('materials.material_name', 'LIKE', "%$search%")
            ->orWhere('type_categories.type_name', 'LIKE', "%$search%")
            ->orWhere('durable_articles.durableArticles_name', 'LIKE', "%$search%");
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
       ->orderBy('categories.id', 'ASC')
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
            ->orderBy('material_name', 'ASC')
            ->get();
        }else{

            $data = DB::table('durable_articles')
            ->where('durable_articles.group_class', '=', $cate[0]->id)
            ->where('durable_articles.remaining_amount', '=',0)
            ->leftJoin('buys', 'durable_articles.id', '=', 'buys.buy_name')
            ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
            ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
            ->whereRaw('buys.buy_name IS NULL OR durable_articles.id != buys.buy_name') // เพิ่มเงื่อนไขนี้
            ->select('durable_articles.*','categories.category_code','type_categories.type_code')
            ->orderBy('durable_articles.id', 'ASC')
            ->groupBy('durable_articles.description')
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
            $amount = $request['quantity'] + $mate[0]->remaining_amount;

            $mat =  Material::find($mate[0]->id);
            $mat->material_number =  $number;
            $mat->remaining_amount =  $amount;
            $mat->save();

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


        }else{




            $dura = DB::table('durable_articles')
            ->where("durable_articles.id",'=',  $request['buy_name'])
            ->orderBy('id', 'ASC')
            ->get();



            $number = $request['quantity'];
            $du = DB::table('durable_articles')
            ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
            ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
            ->where("durable_articles.description",'=',  $dura[0]->description)
            ->where("durable_articles.remaining_amount",'=',  0)
            ->select('durable_articles.*','categories.category_code','type_categories.type_code')
            ->orderBy('id', 'ASC');

            $duCount = $du->count();
            $duArray = $du->get();

            for ($i = 0; $i < $duCount; $i++) {

                $affected = DB::table('durable_articles')
                    ->where('id', $duArray[$i]->id) // แก้ไขจาก description เป็น id
                    ->where('remaining_amount', 0)
                    ->update(['remaining_amount' => 1]);

                    $data = new Buy;
                    $data->typeBuy = $request['type'];
                    $data->group_id = $request['group_id'];
                    $data->buy_name = $request['buy_name'];
                    $data->code_buy = $duArray[$i]->category_code . '-' . $duArray[$i]->type_code . '-' . $duArray[$i]->description . '-' . $duArray[$i]->group_count;
                    $data->quantity =  $request['quantity'];
                    $data->counting_unit = $request['counting_unit'];
                    $data->price_per_piece = $request['price_per_piece'];
                    $data->total_price = $request['total_price'];
                    $data->details = $request['details'];
                    $data->date_enter = $request['date_enter'];
                    $data->status = "0";
                    $data->save();
            }


        }



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



        /* $buy =  Buy::find($id); */
        $buy = DB::table('buys')
        ->leftJoin('categories', 'buys.group_id', '=', 'categories.id')
        ->leftJoin('materials', 'buys.buy_name', '=', 'materials.id')
        ->leftJoin('durable_articles', 'buys.buy_name', '=', 'durable_articles.id')
        ->select('buys.*', 'categories.category_name' , 'materials.material_name',
         'durable_articles.durableArticles_name')
         ->orWhere('buys.id',  $id)
         ->get();


        return view('buy.edit',['buy' => $buy  ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data =  Buy::find($id);

        if ($data->typeBuy == 1) {
            $mate = DB::table('materials')
            ->where("code_material",'=', $data->code_buy)
            ->orderBy('id', 'ASC')
            ->get();


           $number =  ($mate[0]->material_number -  $data->quantity)  + $request['quantity'];
           $amount =  ($mate[0]->remaining_amount -  $data->quantity)  + $request['quantity'];
            $mat =  Material::find($mate[0]->id);
            $mat->material_number =  $number;
            $mat->remaining_amount =  $amount;
            $mat->save();


        }else{

            $parts = explode('-',  $data->code_buy);

            $dura = DB::table('durable_articles')
            ->where("group_class",'=',  $parts[0])
            ->where("type_durableArticles",'=', $parts[1])
            ->where("description",'=', $parts[2])
            ->orderBy('id', 'ASC')
            ->get();

            $number = ($dura[0]->durableArticles_number -  $data->quantity) + $request['quantity'] ;
            $amount = ($dura[0]->remaining_amount -  $data->quantity) + $request['quantity'] ;
            $dur =  DurableArticles::find($dura[0]->id);
            $dur->durableArticles_number =  $number;
            $dur->remaining_amount =  $amount;
            $dur->save();
        }


        $data->quantity = $request['quantity'];
        $data->counting_unit = $request['counting_unit'];
        $data->price_per_piece = $request['price_per_piece'];
        $data->total_price = $request['total_price'];
        $data->date_enter = $request['date_enter'];
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

        if ($data->typeBuy == 1) {
            $mate = DB::table('materials')
            ->where("code_material",'=', $data->code_buy)
            ->orderBy('id', 'ASC')
            ->get();

           $number =  ($mate[0]->material_number -  $data->quantity);
           $amount =  ($mate[0]->remaining_amount -  $data->quantity);
            $mat =  Material::find($mate[0]->id);
            $mat->material_number =  $number;
            $mat->remaining_amount =  $amount;
            $mat->save();


        }else{

            $parts = explode('-',  $data->code_buy);

            $dura = DB::table('durable_articles')
            ->where("group_class",'=',  $parts[0])
            ->where("type_durableArticles",'=', $parts[1])
            ->where("description",'=', $parts[2])
            ->orderBy('id', 'ASC')
            ->get();

            $number = ($dura[0]->durableArticles_number -  $data->quantity);
            $dur =  DurableArticles::find($dura[0]->id);
            $dur->durableArticles_number =  $number;
            $dur->save();
        }



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


}