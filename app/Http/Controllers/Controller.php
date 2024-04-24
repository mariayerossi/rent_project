<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
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
        if ($request->nama == null || $request->tanggal == null || $request->jam == null || $request->alamat == null || $request->durasi == null) {
            return response()->json(['success' => false, 'message' => 'Field tidak boleh kosong!']);
        }
        //masukin db utk dicek ketersediaannya sm admin


        return response()->json(['success' => true, 'message' => 'Berhasil mengisi data! Silahkan tunggu admin melakukan cek ketersediaan mobil.']);
    }
}
