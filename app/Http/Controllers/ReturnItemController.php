<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DurableArticlesRequisition;
use App\Models\DurableArticles;
use DB;
use Auth;
use PDF;

class ReturnItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $search =  $request['search'];
        $data = DB::table('durable_articles_requisitions')
        ->where('durable_articles_requisitions.status',  2)
        ->where('durable_articles_requisitions.statusApproval',  1)
        ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('durable_articles', 'durable_articles_requisitions.group_id', '=', 'durable_articles.id')
        ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
       ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->select('durable_articles_requisitions.*','type_categories.type_name','type_categories.type_code', 'users.prefix', 'users.first_name','users.last_name','departments.department_name',
        'durable_articles.durableArticles_name','durable_articles.warranty_period','durable_articles.description','durable_articles.group_count','durable_articles.durableArticles_number',
        'categories.category_name','categories.category_code','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
        ->selectRaw('count(durable_articles_requisitions.group_withdraw) as groupWithdrawCount');

       if ($search) {
        $data =  $data
            ->where(function ($query) use ($search) {
                $query->where('category_name', 'LIKE', "%$search%")
                    ->orWhere('durableArticles_name', 'LIKE', "%$search%")
                    ->orWhere('first_name', 'LIKE', "%$search%")
                    ->orWhere('last_name', 'LIKE', "%$search%");
            });
        }

       if (Auth::user()->status == "0") {
            $data = $data->where('durable_articles_requisitions.id_user', Auth::user()->id);
        }


       $data = $data->orderBy('durable_articles_requisitions.id','DESC')->paginate(100);

        return view("return_item.index",['data' => $data]);
    }




    public function show(string $id){
        $dataId = DB::table('durable_articles_requisitions')
        ->where('durable_articles_requisitions.id', $id)
        ->get();

        $data = DB::table('durable_articles_requisitions')
        ->where('durable_articles_requisitions.group_withdraw', $dataId[0]->group_withdraw)
        ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('durable_articles', 'durable_articles_requisitions.group_id', '=', 'durable_articles.id')
        ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
        ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->select('durable_articles_requisitions.*','type_categories.type_name','type_categories.type_code', 'users.prefix', 'users.first_name','users.last_name','departments.department_name',
        'durable_articles.durableArticles_name','durable_articles.warranty_period','durable_articles.description','durable_articles.group_count','durable_articles.durableArticles_number',
        'categories.category_name','categories.category_code','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
        ->get();




    return view('durable_articles_requisition.show',['data' =>$data]);
    }

    public function durableRequisitionReturn(string $id)
    {
        $data = DurableArticlesRequisition::find($id);

        $dataRequisitions = DB::table('durable_articles_requisitions')
        ->where('durable_articles_requisitions.group_withdraw', $data->group_withdraw)
        ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('durable_articles', 'durable_articles_requisitions.group_id', '=', 'durable_articles.id')
        ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
        ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->select('durable_articles_requisitions.*','type_categories.type_name','type_categories.type_code', 'users.prefix', 'users.first_name','users.last_name','departments.department_name',
        'durable_articles.durableArticles_name','durable_articles.warranty_period','durable_articles.description','durable_articles.group_count','durable_articles.durableArticles_number','categories.category_name','categories.category_code','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
        ->orderBy('durable_articles_requisitions.id','DESC');

        $requisitions = $dataRequisitions->get();
        $number = $dataRequisitions->count();

           for ($i = 0; $i < $number ; $i++) {

                DurableArticlesRequisition::where('id', $requisitions[$i]->id)->update([
                    'status' =>  2,
                ]);

            }


        return redirect('durable-articles-requisition-index')->with('message', "รอการอนุมัติคึนครุภัณฑ์");
    }

    public function durableRequisitionReturnApproval(string $id)
    {
        $data = DurableArticlesRequisition::find($id);

        $dataRequisitions = DB::table('durable_articles_requisitions')
        ->where('durable_articles_requisitions.group_withdraw', $data->group_withdraw)
        ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('durable_articles', 'durable_articles_requisitions.group_id', '=', 'durable_articles.id')
        ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
        ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->select('durable_articles_requisitions.*','type_categories.type_name','type_categories.type_code', 'users.prefix', 'users.first_name','users.last_name','departments.department_name',
        'durable_articles.durableArticles_name','durable_articles.warranty_period','durable_articles.description','durable_articles.group_count','durable_articles.durableArticles_number','categories.category_name','categories.category_code','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
        ->orderBy('durable_articles_requisitions.id','DESC');

        $requisitions = $dataRequisitions->get();
        $number = $dataRequisitions->count();

           for ($i = 0; $i < $number ; $i++) {

                DurableArticlesRequisition::where('id', $requisitions[$i]->id)->update([
                    'status' =>  3,
                ]);

                DurableArticles::where('id', $requisitions[$i]->group_id)->update([
                    'remaining_amount' =>  1,
                  ]);


            }


        return redirect('return-item-index')->with('message', "อนุมัติคึนครุภัณฑ์");
    }

}
