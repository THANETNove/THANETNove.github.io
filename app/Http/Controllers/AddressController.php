<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{


    public function districts(string $id)
    {

        $data = DB::table('districts')
            ->where('province_id', $id)
            ->get();

        return response()->json($data);
    }

    public function subdistricts(string $id)
    {

        $data = DB::table('subdistricts')
            ->where('districts_id', $id)
            ->get();

        return response()->json($data);
    }
}
