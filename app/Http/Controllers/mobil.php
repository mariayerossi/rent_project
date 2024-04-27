<?php

namespace App\Http\Controllers;

use App\Models\Ketersediaan;
use App\Models\Mobil as ModelsMobil;
use DateTime;
use Illuminate\Http\Request;

class mobil extends Controller
{
    public function daftarMobil() {
        $mob = new ModelsMobil();
        $param["data"] = $mob->get_all_data_admin();

        return view("admin.mobil.daftarMobil")->with($param);
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

    public function editMobil(Request $request) {
        // dd($request->harga);
        if ($request->nama == null || $request->harga == null) {
            return response()->json(['success' => false, 'message' => 'Field tidak boleh kosong!']);
        }

        $status = "Aktif";
        if ($request->status == null) {
            $status = "Non Aktif";
        }

        $data = [
            "id" => $request->id,
            "nama" => $request->nama,
            "harga" => $request->harga,
            "status" => $status
        ];
        $mob = new ModelsMobil();
        $mob->updateMobil($data);

        return response()->json(['success' => true, 'message' => 'Berhasil Mengubah Data!']);
    }

    public function AturKetersediaan(Request $request) {
        $mob = new ModelsMobil();
        $param["data"] = $mob->get_by_id($request->id);

        $sed = new Ketersediaan();
        $param["data2"] = $sed->get_by_id_mobil($request->id);

        return view("admin.mobil.ketersediaan")->with($param);
    }

    public function hapusSedia($id) {
        // dd("halo");
        //kasih pengecekan apakah tanggal hr ini?
        date_default_timezone_set("Asia/Jakarta");
        $skrg = date("Y-m-d H:i:s");
        $skrgg = new DateTime($skrg);

        $sed = new Ketersediaan();
        $mulai = $sed->get_by_id($id)->tanggal_mulai;
        $mulaii = new DateTime($mulai);
        $selesai = $sed->get_by_id($id)->tanggal_selesai;
        $selesaii = new DateTime($selesai);

        if ($mulaii <= $skrgg && $skrgg <= $selesaii) {
            return response()->json(['success' => false, 'message' => 'Gagal Menghapus! Tanggal sudah lewat!']);
        }

        $data = [
            "id" => $id
        ];
        $sed->deleteKetersediaan($data);

        return response()->json(['success' => true, 'message' => 'Berhasil Menghapus!']);
    }

    public function tambahSedia(Request $request) {
        $index = 1;
        while ($request->has("mulai$index") && $request->has("selesai$index")) {
            $id = $request->input("id$index");
            $sed = new Ketersediaan();

            if ($id != null) {
                //proses update
                $mulai = $sed->get_by_id($id)->tanggal_mulai;
                $selesai = $sed->get_by_id($id)->tanggal_selesai;

                //klo ada perubahan, lakukan proses update
                if ($request->input("mulai$index") != $mulai || $request->input("selesai$index") != $selesai) {
                    $data1 = [
                        "id" => $id,
                        "mulai" => $request->input("mulai$index"),
                        "selesai" => $request->input("selesai$index")
                    ];
                    $sed->updateKetersediaan($data1);

                    return response()->json(['success' => true, 'message' => 'Berhasil Mengedit!']);
                }
            }
            else {
                //proses insert
            }
            
            $index++;
        }
    }
}
