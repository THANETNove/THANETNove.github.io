<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use PDF;
use Illuminate\Support\Str;
use App\Models\DurableArticles;

class DurableArticlesController extends Controller
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

        $search =  $request['search']; // ตัวเลขชุดเเรก 7115 คือ group_class 005 คือ  type_durableArticles 0003 คือ description
        $data = DB::table('durable_articles')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
        ->select('durable_articles.*','durable_articles.group_class', 'type_categories.type_name','type_categories.type_code','categories.category_name','categories.category_code','storage_locations.building_name','storage_locations.floor','storage_locations.room_name');
        if ($search) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('categories.category_name', 'LIKE', "%$search%")
                ->orWhere('durable_articles.durableArticles_name', 'LIKE', "%$search%")
                ->orWhere('type_categories.type_name', 'LIKE', "%$search%");
                // Add additional conditions for other cases if needed
            });
           /*  ->orderBy('categories.category_name', 'ASC')
            ->orderBy('type_categories.type_name', 'ASC')
            ->orderBy('durable_articles.durableArticles_name', 'ASC')
            ->paginate(100);
 */

        }

        $data = $data
        ->orderBy('durable_articles.group_class','ASC')
        ->orderBy('durable_articles.type_durableArticles','ASC')
        ->orderBy('durable_articles.description','ASC')
        ->orderBy('durable_articles.group_count','ASC')
        ->orderBy('categories.category_name','ASC')
        ->orderBy('type_categories.type_name', 'ASC')
        ->orderBy('durable_articles.durableArticles_name','ASC')
        ->paginate(100);


      /*   $data = DB::table('durable_articles')->join('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->orderBy('durable_articles.id', 'DESC')
        ->paginate(100);
 */
        return view('durable_articles.index',['data' => $data ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = DB::table('storage_locations')->where('status','on')->get();
        $group = DB::table('categories')
        ->where('category_id', '=', 2)->orderBy('category_name', 'ASC')->get();
        return view('durable_articles.create',['data' => $data,'group' => $group]);
    }
    public function getTypeCategories($id)
    {


        $data = DB::table('type_categories')
        ->where('type_id',$id)
        ->orderBy('type_name', 'ASC')->get();
       return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $durable_cont = DB::table('durable_articles')
        ->where('group_class',$request['group_class'])
        ->where('type_durableArticles', $request['type_durableArticles'])
        ->where('description', $request['description'])
        ->count();
        $currentDate = Carbon::now();
        $thaiYear = ($currentDate->year + 543) % 100;
        $thaiMonth = $currentDate->format('m');

        $countDurable = $thaiMonth . "-" . $thaiYear . "/" . $durable_cont+1;



        $random = "dura-" . Str::random(10);


        $data = new DurableArticles;
        $data->code_DurableArticles = $random;
        $data->group_class = $request['group_class'];
        $data->type_durableArticles = $request['type_durableArticles'];
        $data->description = $request['description'];
        $data->group_count = $countDurable;
        $data->durableArticles_name = $request['durableArticles_name'];
        $data->durableArticles_number = $request['durableArticles_number'];
       /*  $data->remaining_amount = $request['durableArticles_number']; */
        $data->name_durableArticles_count = $request['name_durableArticles_count'];
        $data->code_material_storage = $request['code_material_storage'];
        $data->warranty_period = $request['warranty_period'];
        $data->damaged_number = 0;
        $data->bet_on_distribution_number = 0;
        $data->repair_number = 0;
        $data->status = "on";
        $data->save();



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
        $dueArt =  DurableArticles::find($id);
        $data = DB::table('storage_locations')->where('status','on')->get();
        $group = DB::table('categories')
        ->where('category_id', '=', 2)->orderBy('id', 'DESC')->get();
        return view('durable_articles.edit',['dueArt' => $dueArt ,'data' =>   $data,'group' => $group ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data =  DurableArticles::find($id);
        $data->group_class = $request['group_class'];
        $data->type_durableArticles = $request['type_durableArticles'];
        $data->description = $request['description'];
        $data->durableArticles_name = $request['durableArticles_name'];
        $data->durableArticles_number = $request['durableArticles_number'];
        $data->remaining_amount = $request['durableArticles_number'];
        $data->name_durableArticles_count = $request['name_durableArticles_count'];
        $data->code_material_storage = $request['code_material_storage'];
        $data->warranty_period = $request['warranty_period'];
        $data->save();

        return redirect('durable-articles-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function exportPDF()
    {
        $currentYear = date('Y');

        $data = DB::table('durable_articles')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
        ->select('durable_articles.*','durable_articles.group_class', 'type_categories.type_name','type_categories.type_code','categories.category_name','categories.category_code','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
        ->get();
        $pdf = PDF::loadView('durable_articles.exportPDF',['data' =>  $data,'currentYear' => $currentYear]);
        $pdf->setPaper('a4');
       return $pdf->stream('exportPDF.pdf');
    }
}
