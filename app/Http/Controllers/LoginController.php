<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\UserList;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    //
 
    public function index()
    {
        return view('login');
    }

    public function loginformsubmit(Request $req)
    {
        $username = $req->username;
        $password = $req->password;
        $checkphone_number = UserList::where('loginId', $username)->where('staus',184)->first();
    
        if ($checkphone_number) {
            // Check the provided password against the hashed password in the database
            if (Hash::check($password, $checkphone_number->password)) {
                session(['userinfo' => $checkphone_number]);
                $msg = 'User found';
                $resp = 1;
            } else {
                $msg = 'Password Not Match';
                $resp = 3;
            }
        } else {
            $msg = 'Phone Number Not Found';
            $resp = 2;
        }

        //dd('dede'.$msg);
    
        return response()->json(['resp' => $resp, 'msg' => $msg]);
    }

    public function logout(Request $req)
    {
       
        Session::flush();
        return response()->json(['resp' => 1, 'msg' => '']);
    }


}
