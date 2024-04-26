<?php

namespace App\Http\Controllers;

use App\Models\Dtrans;
use App\Models\Htrans;
use App\Models\Mobil;
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
        session()->put('jenis', $request->jenis);

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

        //masukin db utk dicek ketersediaannya sm admin
        $skrg = date("Y-m-d H:i:s");

        $jenis = "";
        if (session()->has("jenis") || session()->get("jenis") != null) {
            $jenis = session()->get("jenis");
        }
        else {
            return response()->json(['success' => false, 'message' => 'Silahkan pilih jenis perjalanan di pricelist!']);
        }

        //data cust disimpan di session
        if (session()->has("data")) {
            session()->forget('data');
        }

        $data = [
            "tanggal_ht" => $skrg,
            "nama" => $request->nama,
            "telepon" => $request->telepon,
            "jenis" => $jenis,
            "tanggal_jem" => $request->tanggal,
            "jam" => $request->jam,
            "alamat" => $request->alamat,
            "durasi" => $request->durasi
        ];
            
        session()->put('data', $data);

        //transaksi disimpan di db ketika cust bayar saja
        // $dataH = [
        //     "tanggal_ht" => $skrg,
        //     "nama" => $request->nama,
        //     "telepon" => $request->telepon,
        //     "jenis" => $jenis,
        //     "tanggal_jem" => $request->tanggal,
        //     "jam" => $request->jam,
        //     "alamat" => $request->alamat,
        //     "durasi" => $request->durasi
        // ];
        // $ht = new Htrans();
        // $id = $ht->insertHtrans($dataH);

        // if (session()->has("cart") || session()->get("cart") != null) {
        //     foreach (session()->get("cart") as $key => $value) {
        //         $dataD = [
        //             "fk_id_htrans" => $id,
        //             "fk_id_mobil" => $value["id"]
        //         ];
        //         $dt = new Dtrans();
        //         $dt->insertDtrans($dataD);
        //     }
        // }
        // else {
        //     return response()->json(['success' => false, 'message' => 'Silahkan pilih mobil!']);
        // }

        // session()->forget('cart');
        // session()->forget('jenis');

        return response()->json(['success' => true, 'message' => 'Berhasil mengisi data! Silahkan tunggu admin melakukan cek ketersediaan mobil.']);
    }
}
