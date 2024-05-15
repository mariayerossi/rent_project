<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class pembayaran extends Controller
{
    public function tambahDP(Request $request)
    {
        if ($request->persen == "" || $request->jumlah == "" || $request->bukti == null) {
            return response()->json(['success' => false, 'message' => 'Pembayaran tidak valid! Field tidak boleh kosong!']);
        }

        if (!Session::has("jenis") || Session::get("jenis") == null) {
            return response()->json(['success' => false, 'message' => 'Silahkan pilih jenis perjalanan!']);
        }

        if (!Session::has("cart") || Session::get("cart") == null) {
            return response()->json(['success' => false, 'message' => 'Silahkan pilih mobil!']);
        }

        if (!Session::has("data") || Session::get("data") == null) {
            return response()->json(['success' => false, 'message' => 'Silahkan isi data!']);
        }
    }
}
