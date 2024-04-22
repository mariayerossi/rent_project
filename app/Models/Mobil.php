<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;
    //-------- !HARUS ADA! ------------
    protected $table ="mobil";//diganti dengan nama table di database
    protected $primaryKey ="id_mobil";//diganti dengan nama primary key dari table
    public $timestamp = true; //klo true otomatis akan nambah field create_at dan update_at
    public $incrementing = true;//utk increment
    //---------------------------------

    public function insertMobil($data)
    {
        $mob = new Mobil();
        $mob->nama_mobil = $data["nama"];
        $mob->foto_mobil = $data["foto"];
        $mob->harga_mobil = $data["harga"];
        $mob->status_mobil = "Aktif";
        $mob->save();
    }

    public function get_all_data(){
        return Mobil::where('deleted_at',"=",null)->where("status_mobil","=","Aktif")->get();
    }
}
