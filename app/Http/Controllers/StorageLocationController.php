<?php

namespace App\Http\Controllers;

use App\Models\StorageLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class StorageLocationController extends Controller
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
        $data = DB::table('storage_locations');
        if ($search) {

            $data = $data
                ->where('building_name', 'LIKE', "%$search%")
                ->orWhere('floor', 'LIKE', "%$search%")
                ->orWhere('room_name', 'LIKE', "%$search%")
                ->orderBy('id', 'DESC')
                ->paginate(100);
            return view('storage_location.index', ['data' => $data]);
        } else {
            $data = $data
                ->orderBy('id', 'DESC')->paginate(100);

            return view('storage_location.index', ['data' => $data]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('storage_location.create');
    }
    public function storage()
    {
        return view('export.storage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $randomStorage = "stgLoc-" . Str::random(10);

        $data = new StorageLocation;
        $data->code_storage = $randomStorage;
        $data->building_name = $request['building_name'];
        $data->floor = $request['floor'];
        $data->room_name = $request['room_name'];
        $data->status = "on";
        $data->save();

        return redirect('storage-index')->with('message', "บันทึกสำเร็จ");
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
        $data =  StorageLocation::find($id);

        return view('storage_location.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data =  StorageLocation::find($id);
        $data->building_name = $request['building_name'];
        $data->floor = $request['floor'];
        $data->room_name = $request['room_name'];
        $data->save();

        return redirect('storage-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data =  StorageLocation::find($id);

        $data->status = "off";
        $data->save();
        return redirect('storage-index')->with('message', "ยกเลิกสำเร็จ");
    }
    public function updateStatus(string $id)
    {
        $data =  StorageLocation::find($id);

        $data->status = "on";
        $data->save();
        return redirect('storage-index')->with('message', "เปิดใช้สำเร็จ");
    }
    public function exportPDF()
    {
        $name_export = "รายงานสถานที่จัดเก็บ";
        $date_export = Carbon::parse()->locale('th');
        $date_export = $date_export->addYears(543)->translatedFormat('d F Y');

        $data = DB::table('storage_locations')->get();
        $pdf = PDF::loadView('storage_location.exportPDF', ['data' =>  $data, 'name_export' => $name_export, 'date_export' => $date_export]);
        $pdf->setPaper('a4');
        return $pdf->stream('exportPDF.pdf');

        /*   return view('storage_location.exportPDF',['data' => $data]); */
    }
}
