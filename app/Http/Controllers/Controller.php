<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function login(Request $request) {
        if ($request->username == null || $request->password == null) {
            return response()->json(['success' => false, 'message' => 'Username dan password tidak boleh kosong!']);
        }

        if ($request->username != "admin" || $request->password != "123") {
            return response()->json(['success' => false, 'message' => 'Username dan password salah!']);
        }

        //pasang session sek
        // Session::put("role","admin");
        // return redirect('/admin/beranda');
        return response()->json(['success' => true, 'message' => 'BUENERRR!']);
    }

    public function logout(){
        Session::forget('role');
        return redirect("/login");
    }
}
