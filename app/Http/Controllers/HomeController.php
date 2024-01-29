<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Auth;
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

        $search = $request["search"];


        if ($search == 0) {

            $data = DB::table('materials')
            ->whereBetween('materials.created_at', [$start_date, $end_date]) // Add this line
            ->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
            ->leftJoin('categories', 'materials.group_id', '=', 'categories.id')
            ->select('materials.*', 'categories.category_name','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
            ->get();
            $pdf = PDF::loadView('material.exportPDF',['data' =>  $data, 'currentYear' => $currentYear]);
            $pdf->setPaper('a4');
           return $pdf->stream('exportPDF.pdf');


        }elseif ($search == 1) {
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
        $pdf = PDF::loadView('buy.exportPDF',['data' =>  $data, 'currentYear' => $currentYear]);
        $pdf->setPaper('a4');
        return $pdf->stream('exportPDF.pdf');
        }else{

        }


   }
}