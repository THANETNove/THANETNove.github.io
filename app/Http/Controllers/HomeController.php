<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Auth;
use PDF;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->status == 0) {

            return redirect('material-requisition-index');
        }else{
            return redirect('buy-index');
        }

    }
    public function reportDurable()
    {
        $department_type = DB::table('departments')
        ->get();
        $users_type = DB::table('users')
        ->get();
        $categories_type = DB::table('categories')
        ->where('category_id',  1)
        ->get();

        return view('export.export_durable',['department_type' => $department_type,
        'users_type' => $users_type,'categories_type' => $categories_type]);

    }
    public function reportMaterial()
    {
        $department_type = DB::table('departments')
        ->orderBy('department_name', 'ASC')
        ->get();
        $users_type = DB::table('users')
        ->orderBy('first_name', 'ASC')
        ->orderBy('last_name', 'ASC')
        ->get();
        $categories_type = DB::table('categories')
        ->orderBy('category_name', 'ASC')
        ->where('category_id',  1)
        ->get();
        return view('export.export_material',['department_type' => $department_type, 'users_type' => $users_type,'categories_type' => $categories_type]);

    }

    public function myProfile($id)
    {
        $data =  User::find($id);
        return view('personnel.profile',['data' => $data]);
    }
    public function newPassword()
    {

        return view('personnel.new_password');
    }

    public function update(Request $request, string $id)
    {

        User::where('id', $id)->update([
            'password' => Hash::make($request['password']),
            'statusNewPassword' => 1
        ]);

        return redirect('my-profile/' . $id)->with('message', "เปลี่ยน password สำเร็จ");

    }

    public function exportMaterialPDF(Request $request)
    {

        $start_date = $request["start_date"];
        $end_date = $request["end_date"];
        $end_date = Carbon::parse($end_date)->endOfDay()->toDateTimeString();
        $currentYear =  Carbon::parse($start_date)->year;
        $date_export = Carbon::parse()->locale('th');
        $date_export = $date_export->addYears(543)->translatedFormat('d F Y');

        $search = $request["search"];


        if ($search == 0) {  //รายงานวัสดุคงเหลือ
            $name_export = "รายงานวัสดุคงเหลือ";
            $data = DB::table('materials')
            ->whereBetween('materials.created_at', [$start_date, $end_date]) // Add this line
            ->where("materials.remaining_amount",'>', 0)
            ->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
            ->leftJoin('categories', 'materials.group_id', '=', 'categories.id')
            ->select('materials.*', 'categories.category_name','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
            ->get();
            $pdf = PDF::loadView('material.exportPDF',['data' =>  $data, 'date_export' => $date_export,'name_export' => $name_export]);
            $pdf->setPaper('a4');
           return $pdf->stream('exportPDF.pdf');


        }elseif ($search == 1) {
            $name_export = "รายงานวัสดุหมด";
            $data = DB::table('materials')
            ->whereBetween('materials.created_at', [$start_date, $end_date]) // Add this line
            ->where("materials.remaining_amount", 0)
            ->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
            ->leftJoin('categories', 'materials.group_id', '=', 'categories.id')
            ->select('materials.*', 'categories.category_name','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
            ->get();
            $pdf = PDF::loadView('material.exportPDF',['data' =>  $data, 'date_export' => $date_export,'name_export' => $name_export]);
            $pdf->setPaper('a4');
           return $pdf->stream('exportPDF.pdf');

         }elseif ($search == 2) { //รายการรับเข้า
            $name_export = "รายการรับเข้า";
            $data = DB::table('buys')
            ->whereBetween('buys.created_at', [$start_date, $end_date]) // Add this line
            ->where("buys.typeBuy",1)
            ->leftJoin('categories', 'buys.group_id', '=', 'categories.id')
            ->leftJoin('materials', 'buys.buy_name', '=', 'materials.id')
            ->leftJoin('durable_articles', 'buys.buy_name', '=', 'durable_articles.id')
            ->select('buys.*', 'categories.category_name' , 'materials.material_name',
             'durable_articles.durableArticles_name')->where("buys.status",'=',  0);

             if ($request["category"] == 1) {
                $data =  $data->where('categories.category_id', 1);
               }
             if ($request["category"] == 2) {
                $data =  $data->where('categories.category_id', 2);
            }
        $data =  $data->get();
        $pdf = PDF::loadView('buy.exportPDF',['data' =>  $data, 'date_export' => $date_export ,'name_export' => $name_export]);
        $pdf->setPaper('a4');
        return $pdf->stream('exportPDF.pdf');

        }else{

            $data = DB::table('material_requisitions')
            ->whereBetween('material_requisitions.created_at', [$start_date, $end_date]) // Add t
            ->leftJoin('users', 'material_requisitions.id_user', '=', 'users.id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('materials', 'material_requisitions.material_name', '=', 'materials.id')
            ->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
            ->leftJoin('categories', 'material_requisitions.id_group', '=', 'categories.id')
            ->where('material_requisitions.status', "on")
            ->select('material_requisitions.*', 'users.prefix', 'users.first_name','users.last_name',
            'materials.material_name as name','departments.department_name','categories.category_name','storage_locations.building_name','storage_locations.floor','storage_locations.room_name');
            if (Auth::user()->status == "0") {
                $data =  $data->where('id_user', Auth::user()->id);
            }

            if ($search == 3 ) {
                $categories_name = DB::table('categories')
                ->where('id',$request["categories_type"])
                ->get();

                $type = 3;

                $name_export = "รายงานเบิก".$categories_name[0]->category_name;
                $data =  $data->where('material_requisitions.id_group', $request["categories_type"]);
            }
             if ($search == 4 ) {
                $departments_name = DB::table('departments')
                ->where('id',$request["department_type"])
                ->get();
                $type = 4;

                $name_export = "รายงานเบิกวัสดุหน่วยงาน".$departments_name[0]->department_name;
                $data =  $data->where('users.department_id', $request["department_type"]);
            }
            if ($search == 5 ) {
                $users_name = DB::table('users')
                ->where('id',$request["users_type"])
                ->get();
                $type = 5;
                $name_export = "รายงานเบิก "." ".$users_name[0]->prefix." ".$users_name[0]->first_name ." ".$users_name[0]->last_name;
                $data =  $data->where('users.id', $request["users_type"]);
            }



            $pdf = PDF::loadView('material_requisition.exportPDF',['data' =>  $data->get(),'date_export' => $date_export,'name_export' => $name_export ,'type' => $type]);
            $pdf->setPaper('a4');
            return $pdf->stream('exportPDF.pdf');
        }


   }
}
