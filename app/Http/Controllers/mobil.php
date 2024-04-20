<?php

namespace App\Http\Controllers;

use App\Models\Mobil as ModelsMobil;
use Illuminate\Http\Request;

class mobil extends Controller
{
    public function daftarMobil() {
        return view("admin.mobil.daftarMobil");
    }

    public function tambahMobil(Request $request) {
        if ($request->nama == null || $request->foto == null || $request->harga == null) {
            return response()->json(['success' => false, 'message' => 'Field tidak boleh kosong!']);
        }

        $foto = $request->file("foto");
        $destinasi = "/upload";
        $foto2 = uniqid().".".$foto->getClientOriginalExtension();
        $foto->move(public_path($destinasi),$foto2);

        $data = [
            "nama" => $request->nama,
            "foto" => $foto2,
            "harga" => $request->harga
        ];
        $mob = new ModelsMobil();
        $mob->insertMobil($data);

        return response()->json(['success' => true, 'message' => 'Berhasil Menambah Mobil!']);
    }
}
