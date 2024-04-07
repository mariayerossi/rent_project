<?php

use App\Http\Controllers\Controller;
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
});

Route::get('/login', function () {
    return view('admin.login');
});

// ADMIN
Route::prefix("/admin")->group(function(){
    Route::post("/login", [Controller::class, "login"]);
});