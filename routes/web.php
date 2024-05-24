<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\mobil;
use App\Http\Controllers\pembayaran as ControllersPembayaran;
use App\Http\Middleware\admin;
use App\Http\Middleware\cekBayar;
use App\Http\Middleware\cekStatus;
use App\Http\Middleware\guest;
use App\Http\Middleware\guestStatus;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

// CUSTOMER
Route::prefix("/customer")->group(function(){
    Route::get('/pricelist', function () {
        return view('customer.pricelist');
    });
    Route::prefix("/jenis")->group(function(){
        Route::get('/pilih', [Controller::class, "pilihJenis"]);
        Route::get('/clear', [Controller::class, "clearJenis"]);
    });
    Route::prefix("/keranjang")->group(function(){
        Route::post('/tambah', [Controller::class, "tambahKeranjang"]);
        Route::get('/clear', [Controller::class, "clearKeranjang"]);
        Route::get('/hapus/{id}', [Controller::class, "hapusKeranjang"]);
    });
    Route::get('/data', function () {
        return view('customer.data');
    });
    Route::get('/clearData', [Controller::class, "clearData"]);
    Route::get('/clearAll', [Controller::class, "clearAll"]);
    Route::post('/kirimData', [Controller::class, "kirimData"]);
    Route::post('/get_ketersediaan', [mobil::class, "getKetersediaan"]);
    Route::get('/bayar', function () {
        return view('customer.bayar');
    })->middleware([cekBayar::class]);
    Route::prefix("/trans")->group(function(){
        Route::post('/tambahDP', [ControllersPembayaran::class, "tambahDP"]);
        Route::get('/loginStatus', function () {
            return view('customer.loginStatus');
        })->middleware([guestStatus::class]);
        Route::post('/cekStatus', [ControllersPembayaran::class, "cekStatus"]);
        Route::get('/cek/{id}', [ControllersPembayaran::class, "cek"])->middleware([cekStatus::class]);
        Route::post('/bayarSisanya', [ControllersPembayaran::class, "bayarSisanya"]);
    });
});

Route::get("/sendEmail", [Controller::class, "sendEmail"]);

Route::get('/login', function () {
    return view('admin.login');
})->middleware([guest::class]);

// ADMIN
Route::prefix("/admin")->group(function(){
    Route::post("/login", [Controller::class, "login"]);
    Route::get("/logout", [Controller::class, "logout"]);
    Route::get("/beranda", [Controller::class, "beranda"])->middleware([admin::class]);

    Route::prefix("/mobil")->group(function(){
        Route::get("/daftarMobil", [mobil::class, "daftarMobil"])->middleware([admin::class]);
        Route::view("/tambahMobil", "admin.mobil.masterMobil")->middleware([admin::class]);
        Route::post("/tambah", [mobil::class, "tambahMobil"]);
        Route::get("/edit", [mobil::class, "editMobil"]);
        Route::get("/atur/{id}", [mobil::class, "AturKetersediaan"])->middleware([admin::class]);
    });

    Route::prefix("/ketersediaan")->group(function(){
        Route::post("/tambah", [mobil::class, "tambahSedia"]);
        Route::post("/hapus/{id}", [mobil::class, "hapusSedia"]);
    });

    Route::prefix("/sewa")->group(function(){
        Route::get("/daftarSewa", [ControllersPembayaran::class, "daftarSewa"])->middleware([admin::class]);
        Route::get("/detailSewa/{id}", [ControllersPembayaran::class, "detailSewa"])->middleware([admin::class]);
        Route::post("/batalkan", [ControllersPembayaran::class, "batalkanTransAdmin"]);
    });
});