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
            $dataCount = 0;
            return response()->json([$data,  $dataCount] );
        }else{

            $data2 = DB::table('durable_articles')
            ->where('durable_articles.group_class', '=', $cate[0]->id)
            ->leftJoin('buys', 'durable_articles.id', '=', 'buys.buy_name')
            ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
            ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
           /*  ->whereRaw('buys.buy_name IS NULL OR durable_articles.id != buys.buy_name') */ // เพิ่มเงื่อนไขนี้
            ->select('durable_articles.*','categories.category_code','type_categories.type_code');


            $data =  $data2->orderBy('durable_articles.id', 'ASC')
            ->groupBy('durable_articles.description')
            ->get();

            $dataCount =  $data2->orderBy('durable_articles.id', 'ASC')
            ->count();


            $dataStorage =  DB::table('storage_locations')
            ->get();


            return response()->json([$data, $dataCount,$dataStorage]);

        }



    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $durable_cont = DB::table('durable_articles')
        ->where('code_DurableArticles',$request['code_id'])
        ->count();

        $durable_name = DB::table('durable_articles')
        ->where('code_DurableArticles',$request['code_id'])
        ->get();

        $item_name =   $durable_name[0];


        $currentDate = Carbon::now();
        $thaiYear = ($currentDate->year + 543) % 100;
        $thaiMonth = $currentDate->format('m');



    $lj = 1;
    for ($i = 0; $i < $request['quantity']; $i++) {
        $countDurable = $thaiMonth . "-" . $thaiYear . "/" . $durable_cont + $lj++;


        $data = new DurableArticles;
        $data->code_DurableArticles = $request['code_id'];
        $data->group_class = $item_name->group_class;
        $data->type_durableArticles = $item_name->type_durableArticles;
        $data->description = $item_name->description;
        $data->group_count = $countDurable;
        $data->durableArticles_name = $item_name->durableArticles_name;
        $data->durableArticles_number = 1;
        $data->remaining_amount = 1;
        $data->name_durableArticles_count = $item_name->name_durableArticles_count;
        $data->code_material_storage = $request['code_material_storage'];
        $data->warranty_period = $request['warranty_period'];
        $data->price_per = $request['price_per'];
        $data->total_price = $request['total_price'];
        $data->details = $request['details'];
        $data->damaged_number = 0;
        $data->bet_on_distribution_number = 0;
        $data->repair_number = 0;
        $data->status = "on";
        $data->save();
    }


        return redirect('durable-articles-index')->with('message', "บันทึกสำเร็จ");


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


        }


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
            $deleted = Buy::find($id);


            $dura = DB::table('durable_articles')
            ->where("id",'=',  $deleted->buy_name)
            ->where("damaged_number",0)
            ->where("bet_on_distribution_number",0)
            ->where("repair_number",0);
            $dura= $dura->get();
            $duraCount = $dura->count();



            if ($duraCount > 0) {
                $dur =  DurableArticles::find($dura[0]->id);
                $dur->durableArticles_number =  0;
                $dur->save();

                $deleted->delete();
                return redirect('buy-index')->with('message', "ยกเลิกสำเร็จ");
            }else{
                return redirect('buy-index')->with('errorMessage', "ยกเลิกไม่สำเร็จ");
            }

        }





    }
    public function statusBuy(string $id)
    {
        $data =  Buy::find($id);
        $data->status = "1";
        $data->save();

        return redirect('buy-index')->with('message', "ซื้อสำเร็จ");
    }


}
