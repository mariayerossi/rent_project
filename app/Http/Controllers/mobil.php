<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class mobil extends Controller
{
    public function daftarMobil() {
        return view("admin.mobil.daftarMobil");
    }
}
