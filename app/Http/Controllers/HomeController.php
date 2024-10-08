<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        } else {
            if (Auth::user()->status == 3) {
                return redirect('personnel-index');
            } else {
                return redirect('durable-articles-index');
            }
        }
    }
    public function reportDurable()
    {
        $department_type = DB::table('departments')
            ->get();

        $users_type = DB::table('users')
            ->get();
        $categories_type = DB::table('categories')
            ->where('category_id',  2)
            ->get();

        return view('export.export_durable', [
            'department_type' => $department_type,
            'users_type' => $users_type,
            'categories_type' => $categories_type
        ]);
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
        return view('export.export_material', ['department_type' => $department_type, 'users_type' => $users_type, 'categories_type' => $categories_type]);
    }

    public function myProfile($id)
    {
        $data =  User::find($id);
        return view('personnel.profile', ['data' => $data]);
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
        $start_date2 = Carbon::parse($request["start_date"]);
        $end_date2 = Carbon::parse($request["end_date"])->endOfDay();

        $currentYear = $start_date2->year;

        $start_date2->locale('th');
        $end_date2->locale('th');

        $start_date_translated = $start_date2->addYears(543)->translatedFormat('j F') . ' พ.ศ.' . $start_date2->year;
        $end_date_translated = $end_date2->addYears(543)->translatedFormat('j F') . ' พ.ศ.' . $end_date2->year;

        $date_export = $start_date_translated . " ถึง " . $end_date_translated;


        if (Auth::user()->status == "0") {
            $search = 6;
        } else {
            $search = $request["search"];
        }




        if ($search == 0) {  //รายงานวัสดุคงเหลือ
            $name_export = "รายงานวัสดุคงเหลือ";
            $data = DB::table('materials')
                ->whereBetween('materials.created_at', [$start_date, $end_date]) // Add this line
                ->where("materials.remaining_amount", '>', 0)
                ->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
                ->leftJoin('categories', 'materials.group_id', '=', 'categories.id')
                ->select('materials.*', 'categories.category_name', 'storage_locations.building_name', 'storage_locations.floor', 'storage_locations.room_name')
                ->get();


            $pdf = PDF::loadView('material.exportPDF', ['data' =>  $data, 'date_export' => $date_export, 'name_export' => $name_export]);
            $pdf->setPaper('a4');
            return $pdf->stream('exportPDF.pdf');
        } elseif ($search == 1) {
            $name_export = "รายงานวัสดุหมด";
            $data = DB::table('materials')
                ->whereBetween('materials.created_at', [$start_date, $end_date]) // Add this line
                ->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
                ->leftJoin('categories', 'materials.group_id', '=', 'categories.id')
                ->select('materials.*', 'categories.category_name', 'storage_locations.building_name', 'storage_locations.floor', 'storage_locations.room_name')
                ->get();

            $pdf = PDF::loadView('material.exportPDF', ['data' =>  $data, 'date_export' => $date_export, 'name_export' => $name_export]);
            $pdf->setPaper('a4');
            return $pdf->stream('exportPDF.pdf');
        } elseif ($search == 2) { //รายการรับเข้า

            $name_export = "รายการรับเข้าวัสดุ";
            $data = DB::table('buys')
                ->whereBetween('buys.created_at', [$start_date, $end_date]) // Add this line
                ->leftJoin('materials', 'buys.code_buy', '=', 'materials.id')
                ->leftJoin('categories', 'materials.group_id', '=', 'categories.id')

                ->select('materials.*', 'categories.category_name', 'buys.price_per_piece', 'buys.total_price', 'buys.quantity');


            $data =  $data->get();


            $pdf = PDF::loadView('buy.exportPDF', ['data' =>  $data, 'date_export' => $date_export, 'name_export' => $name_export]);
            $pdf->setPaper('a4');
            return $pdf->stream('exportPDF.pdf');
        } else {


            $data = DB::table('material_requisitions')
                ->whereBetween('material_requisitions.created_at', [$start_date, $end_date])
                ->leftJoin('users', 'material_requisitions.id_user', '=', 'users.id')
                ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
                ->leftJoin('materials', 'material_requisitions.material_name', '=', 'materials.id')
                ->leftJoin('storage_locations', 'materials.code_material_storage', '=', 'storage_locations.code_storage')
                ->leftJoin('categories', 'material_requisitions.id_group', '=', 'categories.id')
                ->where('material_requisitions.status', 'on')
                ->select(
                    'material_requisitions.*',
                    'users.prefix',
                    'users.first_name',
                    'users.last_name',
                    'materials.material_name as name',
                    'departments.department_name',
                    'categories.category_name',
                    'storage_locations.building_name',
                    'storage_locations.floor',
                    'storage_locations.room_name',
                    DB::raw('SUM(material_requisitions.amount_withdraw) as amount_withdraw')
                )
                ->groupBy('material_requisitions.id_user', 'material_requisitions.code_requisition');


            if (Auth::user()->status == "0") {
                $data =  $data->where('id_user', Auth::user()->id);
            }

            if ($search == 3) {
                $categories_name = DB::table('categories')
                    ->where('id', $request["categories_type"])
                    ->get();

                $type = 3;

                $name_export = "รายงานเบิก" . $categories_name[0]->category_name;
                $data =  $data->where('material_requisitions.id_group', $request["categories_type"]);
            }
            if ($search == 4) {
                $departments_name = DB::table('departments')
                    ->where('id', $request["department_type"])
                    ->get();
                $type = 4;

                $name_export = "รายงานเบิกวัสดุหน่วยงาน" . $departments_name[0]->department_name;
                $data =  $data->where('users.department_id', $request["department_type"]);
            }
            if ($search == 5) {
                $users_name = DB::table('users')
                    ->where('id', $request["users_type"])
                    ->get();
                $type = 5;
                $name_export = "รายงานเบิก " . " " . $users_name[0]->prefix . " " . $users_name[0]->first_name . " " . $users_name[0]->last_name;
                $data =  $data->where('users.id', $request["users_type"]);
            }
            if ($search == 6) {
                $name_export = "รายงานเบิกวัสดุทั้งหมด";
                $type = 6;
            }
            if ($search == 7) {
                $name_export = "รายงานการรอซื้อ";
                $type = 7;

                $data = DB::table('materials')
                    ->whereBetween('buy_shops.created_at', [$start_date, $end_date]) // Add t
                    ->leftJoin('buy_shops', 'materials.id', '=', 'buy_shops.buy_id')
                    ->leftJoin('categories', 'materials.group_id', '=', 'categories.id')
                    ->select(
                        'materials.*',
                        'buy_shops.required_quantity',
                        'buy_shops.amount_received',
                        'categories.category_name',
                        'buy_shops.created_at AS created_at_shop',
                        DB::raw('SUM(buy_shops.required_quantity) as total_required_quantity'),
                        DB::raw('SUM(buy_shops.amount_received) as total_remaining_amount')
                    )
                    ->groupBy('materials.code_material')
                    ->get();

                $pdf = PDF::loadView('material_requisition.exportPDF_shop', ['data' =>  $data, 'date_export' => $date_export, 'name_export' => $name_export, 'type' => $type]);
                $pdf->setPaper('a4');
                return $pdf->stream('exportPDF.pdf');
            }
            /*   dd($data->get()); */

            $pdf = PDF::loadView('material_requisition.exportPDF', ['data' =>  $data->get(), 'date_export' => $date_export, 'name_export' => $name_export, 'type' => $type]);
            $pdf->setPaper('a4');
            return $pdf->stream('exportPDF.pdf');
        }
    }

    public function exportDurablePDF(Request $request)
    {

        $start_date = $request["start_date"];
        $end_date = $request["end_date"];
        $start_date2 = Carbon::parse($request["start_date"]);
        $end_date2 = Carbon::parse($request["end_date"])->endOfDay();

        $currentYear = $start_date2->year;

        $start_date2->locale('th');
        $end_date2->locale('th');

        $start_date_translated = $start_date2->addYears(543)->translatedFormat('j F') . ' พ.ศ.' . $start_date2->year;
        $end_date_translated = $end_date2->addYears(543)->translatedFormat('j F') . ' พ.ศ.' . $end_date2->year;

        $date_export = $start_date_translated . " ถึง " . $end_date_translated;
        $date_export2 = $start_date_translated;

        if (Auth::user()->status == "0") {
            $search = 6;
        } else {
            $search = $request["search"];
        }


        if ($search == 0) {  //รายงานวัสดุคงเหลือ
            $name_export = "รายงานครุภัณฑ์คงเหลือ";
            $data = DB::table('durable_articles')
                ->whereBetween('durable_articles.created_at', [$start_date, $end_date]) // Add
                ->where("durable_articles.remaining_amount", '>', 0)
                ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
                ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
                ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
                ->select('durable_articles.*', 'durable_articles.group_class', 'type_categories.type_name', 'type_categories.type_code', 'categories.category_name', 'categories.category_code', 'storage_locations.building_name', 'storage_locations.floor', 'storage_locations.room_name')
                ->selectRaw('sum(durable_articles.remaining_amount = 1) as numberCount')
                ->groupBy('durable_articles.code_DurableArticles', 'categories.category_name', 'categories.category_code', 'type_categories.type_name', 'type_categories.type_code')
                ->get();


            $pdf = PDF::loadView('durable_articles.exportPDF', ['data' =>  $data, 'name_export' => $name_export, 'date_export' => $date_export]);
            $pdf->setPaper('a4');
            return $pdf->stream('exportPDF.pdf');
        } elseif ($search == 1) {

            $name_export = "รายงานครุภัณฑ์หมด";
            $data = DB::table('durable_articles')
                ->whereBetween('durable_articles.created_at', [$start_date, $end_date]) // Add
                ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
                ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
                ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
                ->select('durable_articles.*', 'durable_articles.group_class', 'type_categories.type_name', 'type_categories.type_code', 'categories.category_name', 'categories.category_code', 'storage_locations.building_name', 'storage_locations.floor', 'storage_locations.room_name')
                ->selectRaw('sum(durable_articles.remaining_amount) as numberCount')
                ->groupBy('durable_articles.code_DurableArticles', 'categories.category_name', 'categories.category_code', 'type_categories.type_name', 'type_categories.type_code')
                ->get();


            $pdf = PDF::loadView('durable_articles.exportPDF', ['data' =>  $data, 'name_export' => $name_export, 'date_export' => $date_export]);

            $pdf->setPaper('a4');
            return $pdf->stream('exportPDF.pdf');
        } elseif ($search == 2) {
            $name_export = "รายการรับเข้าครุภัณฑ์";
            $data = DB::table('durable_articles')
                ->whereBetween('durable_articles.created_at', [$start_date, $end_date]) // Add this line
                ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
                ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
                ->select('durable_articles.*', 'categories.category_name', 'categories.category_code', 'type_categories.type_name', 'type_categories.type_code')
                ->selectRaw('COUNT(durable_articles.code_DurableArticles) as numberCount')
                ->groupBy('durable_articles.code_DurableArticles', 'categories.category_name', 'categories.category_code', 'type_categories.type_name', 'type_categories.type_code');
            $data =  $data->get();


            $pdf = PDF::loadView('buy.exportPDF_Du', ['data' =>  $data, 'date_export' => $date_export, 'name_export' => $name_export]);
            $pdf->setPaper('a4');
            return $pdf->stream('exportPDF.pdf');
        } elseif ($search >= 3 && $search <=  6) {

            $start_date = $request["start_date"];
            $end_date = $request["end_date"];
            $end_date = Carbon::parse($end_date)->endOfDay()->toDateTimeString();
            $currentYear =  Carbon::parse($start_date)->year;

            $categories_name = DB::table('categories')
                ->where('id', $request["categories_type"])
                ->get();



            $currentYear = date('Y');
            $data = DB::table('durable_articles_requisitions')
                ->whereBetween('durable_articles_requisitions.created_at', [$start_date, $end_date]) // Add this line
                ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
                ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
                ->leftJoin('durable_articles', 'durable_articles_requisitions.group_id', '=', 'durable_articles.id')
                ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
                ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
                ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
                ->select(
                    'durable_articles_requisitions.*',
                    'type_categories.type_name',
                    'users.department_id',
                    'users.id as usersId',
                    'users.prefix',
                    'users.first_name',
                    'users.last_name',
                    'departments.department_name',
                    'durable_articles.durableArticles_name',
                    'durable_articles.warranty_period_start',
                    'durable_articles.warranty_period_end',
                    'categories.category_name',
                    'storage_locations.building_name',
                    'storage_locations.floor',
                    'storage_locations.room_name'
                );




            if (Auth::user()->status == "0") {
                $data =  $data->where('id_user', Auth::user()->id);
            }



            if ($search == 3) {
                $categories_name = DB::table('categories')
                    ->where('id', $request["categories_type"])
                    ->get();

                $type = 3;


                $name_export = "รายงานการเบิก" . $categories_name[0]->category_name;
                $data =  $data->where('durable_articles.group_class', $request["categories_type"]);
            }
            if ($search == 4) {
                $departments_name = DB::table('departments')
                    ->where('id', $request["department_type"])
                    ->get();
                $type = 4;

                $name_export = "รายงานเบิกวัสดุหน่วยงาน" . $departments_name[0]->department_name;
                $data =  $data->where('users.department_id', '=', $request["department_type"]);
            }
            if ($search == 5) {
                $users_name = DB::table('users')
                    ->where('id', $request["users_type"])
                    ->get();
                $type = 5;


                $name_export = "รายงานเบิก " . " " . $users_name[0]->prefix . " " . $users_name[0]->first_name . " " . $users_name[0]->last_name;
                $data =  $data->where('users.id', $request["users_type"]);
            }
            if ($search == 6) {
                $name_export = "รายงานเบิกครุภัณฑ์ทั้งหมด";
                $type = 6;
            }
            $data = $data->get();
            $pdf = PDF::loadView('durable_articles_requisition.exportPDF', ['data' =>  $data, 'name_export' => $name_export, 'date_export' => $date_export, 'type' => $type]);
            $pdf->setPaper('a4');
            return $pdf->stream('exportPDF.pdf');
        } elseif ($search == 7) {
            $name_export = "รายงานครุภัณฑ์ที่ชำรุด";
            $data = DB::table('durable_articles_damageds')
                ->where('durable_articles_damageds.status', 0)
                ->whereBetween('durable_articles_damageds.created_at', [$start_date, $end_date])
                ->join('users', 'durable_articles_damageds.id_user', '=', 'users.id')
                ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
                ->leftJoin('durable_articles', 'durable_articles_damageds.durable_articles_id', '=', 'durable_articles.id')
                ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
                ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
                ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
                ->select(
                    'durable_articles_damageds.*',
                    'users.prefix',
                    'users.first_name',
                    'users.last_name',
                    'departments.department_name',
                    'durable_articles.durableArticles_name',
                    'durable_articles.description',
                    'durable_articles.group_count',
                    'categories.category_name',
                    'categories.category_code',
                    'type_categories.type_name',
                    'type_categories.type_code',
                    'storage_locations.building_name',
                    'storage_locations.floor',
                    'storage_locations.room_name'
                )
                ->get();


            $pdf = PDF::loadView('durable_articles_damaged.exportPDF', ['data' =>  $data, 'name_export' => $name_export, 'date_export' => $date_export]);
            $pdf->setPaper('a4');
            return $pdf->stream('exportPDF.pdf');
        } elseif ($search == 8) {
            $name_export = "รายงานครุภัณฑ์ที่ซ่อม";
            $data = DB::table('durable_articles_repairs')
                ->where('durable_articles_repairs.status', 0)
                ->whereBetween('durable_articles_repairs.created_at', [$start_date, $end_date])
                ->leftJoin('durable_articles', 'durable_articles_repairs.durable_articles_id', '=', 'durable_articles.id')
                ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
                ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
                ->select('durable_articles_repairs.*', 'durable_articles.durableArticles_name', 'durable_articles.name_durableArticles_count', 'categories.category_name', 'type_categories.type_name')
                ->get();
            $pdf = PDF::loadView('durable_articles_repair.exportPDF', ['data' =>  $data, 'name_export' => $name_export, 'date_export' => $date_export]);
            $pdf->setPaper('a4');
            return $pdf->stream('exportPDF.pdf');
        } elseif ($search == 9) {
            $name_export = "รายงานครุภัณฑ์ที่แทงจำหน่าย";
            $data = DB::table('bet_distributions')
                ->where('bet_distributions.status', "on")
                ->where('bet_distributions.statusApproval', "1")
                ->whereBetween('bet_distributions.created_at', [$start_date, $end_date])
                ->leftJoin('durable_articles', 'bet_distributions.durable_articles_id', '=', 'durable_articles.id')
                ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
                ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
                ->select(
                    'bet_distributions.*',
                    'durable_articles.name_durableArticles_count',
                    'durable_articles.durableArticles_name',
                    'categories.category_name',
                    'type_categories.type_name'
                )
                ->get();


            $pdf = PDF::loadView('bet_distribution.exportPDF', ['data' =>  $data, 'name_export' => $name_export, 'date_export' => $date_export]);
            $pdf->setPaper('a4');
            return $pdf->stream('exportPDF.pdf');
        } elseif ($search == 10) {
            $name_export = "รายงานคืนครุภัณฑ์";
            $data = DB::table('durable_articles_requisitions')
                ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
                ->where('durable_articles_requisitions.status', "3")
                ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
                ->leftJoin('durable_articles', 'durable_articles_requisitions.group_id', '=', 'durable_articles.id')
                ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
                ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
                ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
                ->select(
                    'durable_articles_requisitions.*',
                    'type_categories.type_name',
                    'type_categories.type_code',
                    'users.prefix',
                    'users.first_name',
                    'users.last_name',
                    'departments.department_name',
                    'durable_articles.durableArticles_name',
                    'durable_articles.description',
                    'durable_articles.group_count',
                    'durable_articles.warranty_period_start',
                    'durable_articles.warranty_period_end',
                    'categories.category_name',
                    'categories.category_code',
                    'storage_locations.building_name',
                    'storage_locations.floor',
                    'storage_locations.room_name'
                )
                ->get();



            $pdf = PDF::loadView('bet_distribution.exportPDF_2', ['data' =>  $data, 'name_export' => $name_export, 'date_export' => $date_export]);
            $pdf->setPaper('a4');
            return $pdf->stream('exportPDF.pdf');
        } elseif ($search == 11) {

            $name_export = "รายงานค่าเสื่อมครุภัณฑ์";
            /*  $data = DB::table('durable_articles')
        ->whereBetween('durable_articles.created_at', [$start_date, $end_date]) // Add
        ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
        ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
        ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
        ->leftJoin('durable_articles', 'bet_distributions.durable_articles_id', '=', 'durable_articles.id')
        ->select('durable_articles.*','durable_articles.group_class', 'type_categories.type_name','type_categories.type_code','categories.category_name','categories.category_code','storage_locations.building_name','storage_locations.floor','storage_locations.room_name')
        ->selectRaw('sum(durable_articles.remaining_amount) as numberCount')
        ->groupBy('durable_articles.code_DurableArticles', 'categories.category_name', 'categories.category_code', 'type_categories.type_name', 'type_categories.type_code')
        ->get();
        dd($data); */


            $data = DB::table('durable_articles')
                ->whereBetween('durable_articles.updated_at', [$start_date, $end_date])
                ->leftJoin('storage_locations', 'durable_articles.code_material_storage', '=', 'storage_locations.code_storage')
                ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
                ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
                ->leftJoin('bet_distributions', 'bet_distributions.durable_articles_id', '=', 'durable_articles.id')
                ->select(
                    'durable_articles.*', // Selecting all columns from durable_articles
                    'categories.category_name',
                    'categories.category_code',
                    'type_categories.type_name',
                    'type_categories.type_code',
                    'storage_locations.building_name',
                    'storage_locations.floor',
                    'storage_locations.room_name',
                    'bet_distributions.salvage_price'
                )
                // ->whereNotNull('durable_articles.depreciation_price')
                ->selectRaw('sum(durable_articles.remaining_amount) as numberCount') // Summing remaining_amount
                ->groupBy(
                    'durable_articles.code_DurableArticles'
                )
                ->get();


            $pdf = PDF::loadView('durable_articles.exportPDF_2', ['data' =>  $data, 'name_export' => $name_export, 'date_export' => $date_export2]);

            $pdf->setPaper('a4');
            return $pdf->stream('exportPDF.pdf');
        }
    }
}
