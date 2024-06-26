<?php

namespace App\Http\Controllers;

use App\Models\Dtrans;
use App\Models\Htrans;
use App\Models\Ketersediaan;
use App\Models\notifikasiEmail;
use App\Models\Pembayaran as ModelsPembayaran;
use DateTime;
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

        //hitung waktu selesai wisatanya
        $mulai = Session::get("data")["tanggal_jem"];
        $mulaii = new DateTime($mulai);
        $durasi = Session::get("data")["durasi"];
        $selesai = date('Y-m-d', strtotime($mulai . ' + ' . $durasi . ' days'));
        $selesaii = new DateTime($selesai);

        $unavailableCars = [];

        if (Session::has("cart") || Session::get("cart") != null) {
            foreach (session()->get("cart") as $key => $value) {
                $sed = new Ketersediaan();
                $dataSed = $sed->get_by_id_mobil($value["id"]);
                if (!$dataSed->isEmpty()) {
                    foreach ($dataSed as $key2 => $value2) {
                        $sed_mulai = new DateTime($value2->tanggal_mulai);
                        $sed_selesai = new DateTime($value2->tanggal_selesai);
                        //kasi pengecekan apakah waktu yang diberikan customer berbenturan dgn ketersediaan
                        if ($mulaii < $sed_selesai && $selesaii > $sed_mulai) {
                            //mobil tdk tersedia
                            $tanggalAwal = $value2->tanggal_mulai;
                            $tanggalObjek = DateTime::createFromFormat('Y-m-d', $tanggalAwal);
                            $carbonDate = \Carbon\Carbon::parse($tanggalObjek)->locale('id');
                            $tanggalBaru = $carbonDate->isoFormat('D MMMM YYYY');
    
                            $tanggalAwal2 = $value2->tanggal_selesai;
                            $tanggalObjek2 = DateTime::createFromFormat('Y-m-d', $tanggalAwal2);
                            $carbonDate2 = \Carbon\Carbon::parse($tanggalObjek2)->locale('id');
                            $tanggalBaru2 = $carbonDate2->isoFormat('D MMMM YYYY');
                            
                            $unavailableCars[] = $value["nama"]." tidak dapat disewa pada ".$tanggalBaru ." hingga ".$tanggalBaru2;
                        }
                    }
                }
            }
        }

        // dd($unavailableCars);

        if ($unavailableCars != null) {
            return response()->json(['success' => false, 'message' => $unavailableCars]);
        }

        // return response()->json(['success' => false, 'message' => "ga bisa"]);

        date_default_timezone_set("Asia/Jakarta");
        $skrg = date("Y-m-d H:i:s");

        $dataH = [
            "tanggal_ht" => $skrg,
            "nama" => Session::get("data")["nama"],
            "telepon" => Session::get("data")["telepon"],
            "email" => Session::get("data")["email"],
            "jenis" => Session::get("jenis")["nama"],
            "tanggal_jem" => Session::get("data")["tanggal_jem"],
            "jam" => Session::get("data")["jam"],
            "alamat" => Session::get("data")["alamat"],
            "durasi" => Session::get("data")["durasi"],
            "harga" => Session::get("jenis")["harga"],
            "sub_jenis" => Session::get("data")["subtotal_jenis"],
            "sub_mobil" => Session::get("data")["subtotal_mobil"],
            "total" => Session::get("data")["total"]
        ];
        $ht = new Htrans();
        $id = $ht->insertHtrans($dataH);

        //hitung tanggal selesai
        $durasi = Session::get("data")["durasi"];
        $jenis = Session::get("jenis")["nama"];

        $tanggalAwal3 = Session::get("data")["tanggal_jem"] . " " . Session::get("data")["jam"];
        $tanggalObjek3 = DateTime::createFromFormat('Y-m-d H:i', $tanggalAwal3);
        $carbonDate3 = \Carbon\Carbon::parse($tanggalObjek3)->locale('id');
        
        if ($jenis == "City Tour" || $jenis == "Zona I") {
            // Durasi dalam jam
            $carbonDateKembali = $carbonDate3->copy()->addHours($durasi);
        } else {
            // Durasi dalam hari
            $carbonDateKembali = $carbonDate3->copy()->addDays($durasi);
        }
        $tanggalKembali = $carbonDateKembali->format('Y-m-d');
        // dd($tanggalKembali);

        if (session()->has("cart") || session()->get("cart") != null) {
            foreach (session()->get("cart") as $key => $value) {
                $dataD = [
                    "fk_id_htrans" => $id,
                    "fk_id_mobil" => $value["id"]
                ];
                $dt = new Dtrans();
                $dt->insertDtrans($dataD);

                //tambah ketersediaan
                $dataK = [
                    "fk_id_mobil" => $value["id"],
                    "mulai" => Session::get("data")["tanggal_jem"],
                    "selesai" => $tanggalKembali
                ];
                $sed = new Ketersediaan();
                $sed->insertKetersediaan($dataK);
            }
        }
        else {
            return response()->json(['success' => false, 'message' => 'Silahkan pilih mobil!']);
        }

        $foto = $request->file("bukti");
        $destinasi = "/upload";
        $foto2 = uniqid().".".$foto->getClientOriginalExtension();
        $foto->move(public_path($destinasi),$foto2);

        $dataP = [
            "fk_id_htrans" => $id,
            "tanggal" => $skrg,
            "persen" => $request->persen,
            "jumlah" => $request->jumlah,
            "bukti" => $foto2
        ];
        $byr = new ModelsPembayaran();
        $byr->insertPembayaran($dataP);

        $tanggalAwal3 = Session::get("data")["tanggal_jem"];
        $tanggalObjek3 = DateTime::createFromFormat('Y-m-d', $tanggalAwal3);
        $carbonDate3 = \Carbon\Carbon::parse($tanggalObjek3)->locale('id');
        $tanggalBaru3 = $carbonDate3->isoFormat('D MMMM YYYY');

        $dataNotif = [
            "subject" => "🎉Pembayaran DP Berhasil🎉",
            "judul" => "Pembayaran DP Berhasil!",
            "nama_user" => Session::get("data")["nama"],
            "url" => "/customer/trans/loginStatus",
            "button" => "Cek Status",
            "isi" => "Pembayaran DP sebesar Rp ".number_format($request->jumlah, 0, ',', '.')."<br>
                    pada persewaan tanggal ".$tanggalBaru3."<br>
                    Telah berhasil! 😊"
        ];
        $e = new notifikasiEmail();
        $e->sendEmail(Session::get("data")["email"], $dataNotif);

        // session()->forget('cart');
        // session()->forget('jenis');
        // session()->forget('data');

        return response()->json(['success' => true, 'message' => 'Berhasil melakukan pembayaran! Silahkan cek status pembayaran']);
    }

    public function cekStatus(Request $request)
    {
        if ($request->nama == "" || $request->telepon == "" || $request->tanggal == null) {
            return response()->json(['success' => false, 'message' => 'Field tidak boleh kosong!']);
        }

        $ht = new Htrans();
        $data = $ht->get_all_data();

        if ($data != null || !$data->isEmpty()) {
            $status = 0;
            foreach ($data as $key => $value) {
                if ($request->nama == $value->nama_cust && $request->telepon == $value->telepon_cust && $request->tanggal == $value->tanggal_jemput) {
                    $status = $value->id_htrans;
                }
            }
            // dd($status);

            //buat session status
            session()->put('status', $status);

            if ($status != 0) {
                return response()->json(['success' => true, 'message' => $status]);
            }
            else {
                return response()->json(['success' => false, 'message' => 'Tidak ada data tersimpan!']);
            }
        }
    }

    public function cek($id)
    {
        $ht = new Htrans();
        $param["dataH"] = $ht->get_data_by_id($id);

        $dt = new Dtrans();
        $param["dataD"] = $dt->get_data_by_id_htrans($id);

        $by = new ModelsPembayaran();
        $param["dataP"] = $by->get_data_by_id_htrans($id);

        return view("customer.status")->with($param);
    }

    public function bayarSisanya(Request $request)
    {
        if ($request->bukti == null) {
            return response()->json(['success' => false, 'message' => 'Bukti Pembayaran tidak boleh kosong!']);
        }

        date_default_timezone_set("Asia/Jakarta");
        $skrg = date("Y-m-d H:i:s");

        $foto = $request->file("bukti");
        $destinasi = "/upload";
        $foto2 = uniqid().".".$foto->getClientOriginalExtension();
        $foto->move(public_path($destinasi),$foto2);

        $dataP = [
            "fk_id_htrans" => $request->htrans,
            "tanggal" => $skrg,
            "persen" => $request->persen,
            "jumlah" => $request->jumlah,
            "bukti" => $foto2
        ];
        $byr = new ModelsPembayaran();
        $byr->insertPembayaran($dataP);

        //edit status htrans menjadi "Lunas"
        $dataH = [
            "id" => $request->htrans,
            "status" => "Lunas"
        ];
        $ht = new Htrans();
        $ht->updateStatus($dataH);

        return response()->json(['success' => true, 'message' => 'Berhasil Melunasi Pembayaran!']);
    }

    public function daftarSewa()
    {
        $ht = new Htrans();
        $param["menunggu"] = $ht->get_all_data_menunggu();

        $param["lunas"] = $ht->get_all_data_lunas();

        $param["selesai"] = $ht->get_all_data_selesai();

        $param["dibatalkan"] = $ht->get_all_data_dibatalkan();

        return view("admin.sewa.daftarSewa")->with($param);
    }

    public function detailSewa($id)
    {
        $ht = new Htrans();
        $param["dataH"] = $ht->get_data_by_id($id);

        $dt = new Dtrans();
        $param["dataD"] = $dt->get_data_by_id_htrans($id);

        $by = new ModelsPembayaran();
        $param["dataP"] = $by->get_data_by_id_htrans($id);

        return view("admin.sewa.detailSewa")->with($param);
    }

    public function batalkanTransAdmin(Request $request)
    {
        if ($request->status_htrans == "Menunggu" || $request->status_htrans == "Lunas") {
            $data = [
                "id" => $request->id_htrans,
                "status" => "Dibatalkan"
            ];
            $ht = new Htrans();
            $ht->updateStatus($data);

            $tanggalAwal3 = $request->tanggal;
            $tanggalObjek3 = DateTime::createFromFormat('Y-m-d', $tanggalAwal3);
            $carbonDate3 = \Carbon\Carbon::parse($tanggalObjek3)->locale('id');
            $tanggalBaru3 = $carbonDate3->isoFormat('D MMMM YYYY');

            $dataNotif = [
                "subject" => "🔔Sewa Dibatalkan Admin🔔",
                "judul" => "Sewa Dibatalkan oleh Admin!",
                "nama_user" => $request->nama_cust,
                "url" => "/customer/trans/loginStatus",
                "button" => "Cek Status",
                "isi" => "Persewaan pada tanggal: ".$tanggalBaru3."<br>
                        dengan jenis perjalanan: ".$request->jenis."<br><br>
                        Telah dibatalkan oleh Admin! Silahkan lakukan persewaan lain😊"
            ];
            $e = new notifikasiEmail();
            $e->sendEmail($request->email_cust, $dataNotif);
        }
        else {
            return response()->json(['success' => false, 'message' => 'Gagal Membatalkan!']);
        }

        return response()->json(['success' => true, 'message' => 'Berhasil Membatalkan!']);
    }
}
