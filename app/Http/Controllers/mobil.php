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
        $data2 = $sed->get_by_id_mobil($request->id);

        // //(opsional klo cronjob ga bisa) hapus data yang sudah lewat
        // date_default_timezone_set("Asia/Jakarta");
        // $skrg = date("Y-m-d");
        
        // foreach ($data2 as $key => $value) {
        //     if ($value->tanggal_selesai < $skrg) {
        //         $data3 = [
        //             "id" => $value->id_sedia
        //         ];
        //         $sed->deleteKetersediaan($data3);
        //     }
        // }

        $param["data2"] = $data2;

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
            //kasih pengecekan apakah tanggal akhir kurang dr tanggal awal
            if ($request->input("mulai$index") > $request->input("selesai$index")) {
                return response()->json(['success' => false, 'message' => 'Tanggal tidak valid!']);
            }

            //kasih pengecekan apakah tanggal awal kurang dari tanggal sekarang
            date_default_timezone_set("Asia/Jakarta");
            $skrg = date("Y-m-d");
            if ($request->input("mulai$index") < $skrg) {
                return response()->json(['success' => false, 'message' => 'Tanggal tidak valid!']);
            }


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
                }
            }

            if ($id == null) {
                //proses insert
                $data2 = [
                    "fk_id_mobil" => $request->id_mobil,
                    "mulai" => $request->input("mulai$index"),
                    "selesai" => $request->input("selesai$index")
                ];
                $sed->insertKetersediaan($data2);
            }

            $index++;
        }
        return response()->json(['success' => true, 'message' => 'Berhasil Melakukan Perubahan!']);
    }

    public function getKetersediaan(Request $request)
    {
        $id = $request->id;
        // Fetch availability data based on the provided ID
        $data = [
            "id" => $id
        ];
        $sed = new Ketersediaan();
        $ketersediaan = $sed->get_by_id_mobil($data);

        $data2 = "";
        if (!$ketersediaan->isEmpty()) {
            foreach ($ketersediaan as $key => $value) {
                if ($value->tanggal_mulai != $value->tanggal_selesai) {
    
                    $tanggalAwal = $value->tanggal_mulai;
                    $tanggalObjek = DateTime::createFromFormat('Y-m-d', $tanggalAwal);
                    $carbonDate = \Carbon\Carbon::parse($tanggalObjek)->locale('id');
                    $tanggalBaru = $carbonDate->isoFormat('D MMMM YYYY');
    
                    $tanggalAwal2 = $value->tanggal_selesai;
                    $tanggalObjek2 = DateTime::createFromFormat('Y-m-d', $tanggalAwal2);
                    $carbonDate2 = \Carbon\Carbon::parse($tanggalObjek2)->locale('id');
                    $tanggalBaru2 = $carbonDate2->isoFormat('D MMMM YYYY');
    
                    $data2 .= $tanggalBaru . " - ".$tanggalBaru2."<br>";
                }
                else {
                    $data2 .= $value->tanggal_mulai."<br>";
                }
            }
        }
        else {
            $data2 = "-";
        }
        
        // You can customize the response as needed, here I'm just returning availability data
        return response()->json([
            'success' => true,
            'data' => $data2, // Assuming you have a field named tanggal_unavailable
        ]);
    }
}
