<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use PDF;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class PersonnelController extends Controller
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
        $statusEmployee = null;

        if( $request['search'] == 'พนักงาน') {
            $statusEmployee = "on";
        }
        if( $request['search'] == 'พ้นสภาพพนักงาน') {
            $statusEmployee = "off";
        }


        $data = DB::table('users')->leftJoin('departments', 'users.department_id', '=', 'departments.id')->select('users.*', 'departments.department_name');

        if ($search) {
            $data = $data->where(function ($query) use ($search, $statusEmployee) {
                $query->where('employee_id', 'LIKE', "%$search%")
                      ->orWhere('first_name', 'LIKE', "%$search%");
                if ($statusEmployee) {
                    $query->orWhere('statusEmployee', $statusEmployee);
                }
            })
            ->orderBy('id', 'DESC')
            ->paginate(100);


        }else{
            $data = $data
           ->orderBy('id','DESC')->paginate(100);

        }

        return view('personnel.index',['data' => $data]);

    }

    public function personnel()  {
        return view('export.personnel');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = DB::table('departments')->where('status', '=', "on") ->orderBy('id', 'DESC')->get();
        return view('personnel.create',["data" => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['required', 'string', 'regex:/^[0-9]+$/'],
        ]);



         User::create([
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'employee_id' => $request['employee_id'],
            'prefix' => $request['prefix'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'phone_number' => $request['phone_number'],
            'department_id' => $request['department_id'],
            'address' => $request['address'],
            'provinces' => $request['provinces'],
            'districts' => $request['districts'],
            'subdistrict' => $request['subdistrict'],
            'zip_code' => $request['zip_code'],
            'status' => "0",
            'statusEmployee' => "on",
            'statusNewPassword' => NULL
        ]);

        return redirect('personnel-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->select('users.*', 'departments.department_name')
        ->find($id);
        return view('personnel.show',['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data =  User::find($id);
        $depart = DB::table('departments')->where('status', '=', "on") ->orderBy('id', 'DESC')->get();
        return view('personnel.edit',['data' => $data,'depart' => $depart]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validated = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($id),
            ],
            'phone_number' => ['required', 'string', 'regex:/^[0-9]+$/'],
        ]);


        User::where('id', $id)->update([
            'email' => $request['email'],
            'password' => $request['password'],
            'employee_id' => $request['employee_id'],
            'prefix' => $request['prefix'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'phone_number' => $request['phone_number'],
            'department_id' => $request['department_id'],
            'address' => $request['address'],
            'provinces' => $request['provinces'],
            'districts' => $request['districts'],
            'subdistrict' => $request['subdistrict'],
            'zip_code' => $request['zip_code'],
            'status' => $request['status'],
            'statusEmployee' => $request['statusEmployee'],
        ]);

        return redirect('personnel-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data =  User::find($id);

        $data->statusEmployee = "off";
        $data->save();
        return redirect('personnel-index')->with('message', "ยกเลิกสำเร็จ");
    }

    public function updateStatus(string $id)
    {
        $data =  User::find($id);

        $data->statusEmployee = "on";
        $data->save();
        return redirect('personnel-index')->with('message', "เปิดใช้สำเร็จ");
    }

    public function exportPDF()
    {
        $name_export = "รายงานข้อมูลบุคลากร";
        $date_export = Carbon::parse()->locale('th');
        $date_export = $date_export->addYears(543)->translatedFormat('d F Y');


        $data = DB::table('users')->get();
        $pdf = PDF::loadView('personnel.exportPDF',['data' =>  $data,'name_export' => $name_export,'date_export' => $date_export]);
        $pdf->setPaper('a4');
       return $pdf->stream('exportPDF.pdf');

    }
}
