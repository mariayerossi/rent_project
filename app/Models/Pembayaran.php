<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    //-------- !HARUS ADA! ------------
    protected $table ="pembayaran";//diganti dengan nama table di database
    protected $primaryKey ="id_bayar";//diganti dengan nama primary key dari table
    public $timestamp = true; //klo true otomatis akan nambah field create_at dan update_at
    public $incrementing = true;//utk increment
    //---------------------------------

    public function insertPembayaran($data)
    {
        $byr = new Pembayaran();
        $byr->fk_id_htrans = $data["fk_id_htrans"];
        $byr->tanggal = $data["tanggal"];
        $byr->persen = $data["persen"];
        $byr->jumlah = $data["jumlah"];
        $byr->bukti = $data["bukti"];
        $byr->save();
    }

    public function get_data_by_id_htrans($id){
        return Pembayaran::where("fk_id_htrans","=",$id)->get();
    }
}
