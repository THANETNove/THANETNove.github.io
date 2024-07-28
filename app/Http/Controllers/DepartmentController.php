<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Department;


class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth');
    }



    public function index()
    {
        $data = DB::table('departments')->where('status', '=', "on")->orderBy('id', 'DESC')
            ->paginate(100);
        return view('department.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $data = new Department;

        $data->department_name = $request['department_name'];
        $data->status = "on";
        $data->save();

        return redirect('department-index')->with('message', "บันทึกสำเร็จ");
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

        $data =  Department::find($id);

        return view('department.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data =  Department::find($id);
        $data->department_name = $request['department_name'];
        $data->save();

        return redirect('department-index')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data =  Department::find($id);
        $data->status = "off";
        $data->save();
        return redirect('department-index')->with('message', "ยกเลิกสำเร็จ");
    }
}
