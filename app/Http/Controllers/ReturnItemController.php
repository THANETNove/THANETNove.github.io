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
        ->where('durable_articles_requisitions.status',  0)
        ->where('durable_articles_requisitions.statusApproval',  1)
        ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('durable_articles', 'durable_articles_requisitions.durable_articles_name', '=', 'durable_articles.id')
        ->leftJoin('categories', 'durable_articles_requisitions.group_id', '=', 'categories.id')
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->select('durable_articles_requisitions.*', 'users.prefix', 'users.first_name','users.last_name','departments.department_name',
    'durable_articles.durableArticles_name','categories.category_name','storage_locations.building_name','storage_locations.floor','storage_locations.room_name');

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


    public function durableRequisitionReturn(string $id)
    {
        $data_requisition = DurableArticlesRequisition::find($id);
        $data = DurableArticles::find($data_requisition->durable_articles_name);


        DurableArticles::where('id', $data_requisition->durable_articles_name)->update([
            'remaining_amount' =>  $data->remaining_amount + $data_requisition->amount_withdraw,
        ]);
        DurableArticlesRequisition::where('id', $id)->update([
            'status' =>  "3",
        ]);
        return redirect('return-item-index')->with('message', "ยกเลิกสำเร็จ");
    }

}
