<?php

namespace App\Http\Controllers;

use App\Models\Dtrans;
use App\Models\Htrans;
use App\Models\Ketersediaan;
use App\Models\Mobil;
use App\Models\notifikasiEmail;
use DateInterval;
use DateTime;
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
        Session::put("role","admin");
        return response()->json(['success' => true, 'message' => 'BUENERRR!']);
    }

    public function logout(){
        Session::forget('role');
        return redirect("/login");
    }

    public function beranda() {
        return view('admin.beranda');
    }

    public function pilihJenis(Request $request) {
        // dd($request->jenis);

        if (session()->has("jenis")) {
            session()->forget('jenis');
        }
        
        $data = [
            "nama" => $request->jenis,
            "harga" => $request->harga
        ];
        session()->put('jenis', $data);

        $mob = new Mobil();
        $param["data"] = $mob->get_all_data();
        return view('customer.daftarMobil')->with($param);
    }

    public function tambahKeranjang(Request $request) {
        $productId = $request->id;
        // dd($productId);
        $mob = Mobil::find($productId);

        if ($mob) {
            // Ambil keranjang belanja dari sesi
            $cart = [];
            if (session()->has('cart')) {
                $cart = session()->get('cart');
            }

            // Tambahkan item baru ke keranjang
            $cart[$productId] = [
                'id' => $mob->id_mobil,
                'nama' => $mob->nama_mobil,
                'harga' => $mob->harga_mobil,
                // Informasi lain yang mungkin Anda perlukan
            ];
            // dd($cart);

            // Simpan keranjang belanja kembali ke sesi
            session()->put('cart', $cart);

            return response()->json(['success' => true, 'message' => 'Berhasil menambah item!']);
        }
        // return redirect()->back();
        return response()->json(['success' => false, 'message' => 'Gagal Menambah item!']);
    }

    public function clearKeranjang()
    {
        // Kosongkan keranjang belanja dengan menghapus sesi 'cart'
        session()->forget('cart');

        return response()->json(['success' => true, 'message' => 'Berhasil menghapus semua item!']);
    }

    public function clearJenis()
    {
        // Kosongkan keranjang belanja dengan menghapus sesi 'jenis'
        session()->forget('jenis');

        return response()->json(['success' => true, 'message' => 'Berhasil menghapus semua item!']);
    }

    public function clearData()
    {
        // Kosongkan keranjang belanja dengan menghapus sesi 'data'
        session()->forget('data');

        return response()->json(['success' => true, 'message' => 'Berhasil menghapus semua item!']);
    }

    public function clearAll()
    {
        // Kosongkan keranjang belanja dengan menghapus sesi semua
        session()->forget('jenis');
        session()->forget('cart');
        session()->forget('data');

        return response()->json(['success' => true, 'message' => 'Berhasil menghapus semua item!']);
    }

    public function hapusKeranjang($productId) {
        // Ambil keranjang belanja dari sesi
        $cart = session()->get('cart');

        // Hapus item dari keranjang berdasarkan ID produk
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            // Simpan kembali keranjang belanja ke sesi
            session()->put('cart', $cart);
        }

        return response()->json(['success' => true, 'message' => 'Berhasil menghapus item!']);
    }

    public function kirimData(Request $request) {
        // return response()->json(['success' => false, 'message' => $request->tanggal]);
        if ($request->nama == null || $request->telepon == null || $request->tanggal == null || $request->jam == null || $request->alamat == null || $request->durasi == null) {
            return response()->json(['success' => false, 'message' => 'Field tidak boleh kosong!']);
        }

        date_default_timezone_set("Asia/Jakarta");
        $tgl_skrg = date("Y-m-d");

        //minimal pesan h-15 hari h
        $sewa = new DateTime($request->tanggal);
        $sewa->sub(new DateInterval('P15D'));
        $tgl_min = $sewa->format('Y-m-d');

        if ($tgl_skrg > $tgl_min) {
            return response()->json(['success' => false, 'message' => 'Pemesanan melalui website dilakukan minimal 15 hari sebelumnya. Jika mendesak, silahkan lakukan pemesanan manual di Whatsapp!']);
        }

        //cek ketersediaan mobil di tanggal tsb
        if (!session()->has("cart") || session()->get("cart") == null) {
            return response()->json(['success' => false, 'message' => 'Silahkan pilih mobil!']);
        }

        //hitung waktu selesai wisatanya
        $mulai = $request->tanggal;
        $mulaii = new DateTime($mulai);
        $durasi = $request->durasi;
        $selesai = date('Y-m-d', strtotime($mulai . ' + ' . $durasi . ' days'));
        $selesaii = new DateTime($selesai);

        $unavailableCars = [];

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

        if ($unavailableCars != null) {
            return response()->json(['success' => false, 'message' => $unavailableCars]);
        }

        $skrg = date("Y-m-d H:i:s");

        $jenis = "";
        $harga = 0;
        if (session()->has("jenis") || session()->get("jenis") != null) {
            $jenis = session()->get("jenis")["nama"];
            $harga = session()->get("jenis")["harga"];
        }
        else {
            return response()->json(['success' => false, 'message' => 'Silahkan pilih jenis perjalanan di pricelist!']);
        }

        //pengecekan min. hari/jam sesuai dengan jenis perjalanan
        if ($jenis == "Zona I" && $request->durasi > 15) {
            return response()->json(['success' => false, 'message' => 'Durasi perjalanan Zona I maximal 15 jam']);
        }
        else if ($jenis == "Zona II" && $request->durasi < 2) {
            return response()->json(['success' => false, 'message' => 'Durasi perjalanan Zona II minimal 2 hari']);
        }
        else if ($jenis == "Zona III" && $request->durasi < 3) {
            return response()->json(['success' => false, 'message' => 'Durasi perjalanan Zona III minimal 3 hari']);
        }

        $subtotal_jenis = $harga * $request->durasi;

        $subtotal_mobil = 0;
        foreach (session()->get("cart") as $key => $value) {
            $subtotal_mobil += $value["harga"];
        }

        $total = $subtotal_jenis + $subtotal_mobil;
        
        //data cust disimpan di session
        if (session()->has("data")) {
            session()->forget('data');
        }

        $data = [
            "tanggal_ht" => $skrg,
            "nama" => $request->nama,
            "telepon" => $request->telepon,
            "email" => $request->email,
            "jenis" => $jenis,
            "tanggal_jem" => $request->tanggal,
            "jam" => $request->jam,
            "alamat" => $request->alamat,
            "durasi" => $request->durasi,
            "subtotal_jenis" => $subtotal_jenis,
            "subtotal_mobil" => $subtotal_mobil,
            "total" => $total
        ];
            
        session()->put('data', $data);

        return response()->json(['success' => true, 'message' => 'Berhasil mengisi data!']);
    }

    public function sendEmail() {
        $dataNotif = [
            "subject" => "Testing email",
            "judul" => "Penawaran Alat Olahraga Baru",
            "nama_user" => "Maria Yerossi",
            "isi" => "Anda memiliki 1 penawaran alat olahraga baru yang masih belum diterima.Silahkan terima penawaran!",
            "url" => "https://sportiva.my.id/login/",
            "button" => "Login"
        ];
        // Mail::to("maria.yerossi@gmail.com")->send(new notifEmail($data));
        $e = new notifikasiEmail();
        $e->sendEmail("maria_y20@mhs.istts.ac.id",$dataNotif);
    }
}
