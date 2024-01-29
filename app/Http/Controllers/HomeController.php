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
    public function report()
    {
        return view('export.index');

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
}
