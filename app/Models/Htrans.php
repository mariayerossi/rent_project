<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Htrans extends Model
{
    use HasFactory;
    //-------- !HARUS ADA! ------------
    protected $table ="htrans";//diganti dengan nama table di database
    protected $primaryKey ="id_htrans";//diganti dengan nama primary key dari table
    public $timestamp = true; //klo true otomatis akan nambah field create_at dan update_at
    public $incrementing = true;//utk increment
    //---------------------------------

    public function insertHtrans($data)
    {
        $ht = new Htrans();
        $ht->tanggal_htrans = $data["tanggal_ht"];
        $ht->nama_cust = $data["nama"];
        $ht->telp_cust = $data["telp"];
        $ht->jenis = $data["jenis"];
        $ht->tanggal_jemput = $data["tanggal_jem"];
        $ht->jam_jemput = $data["jam"];
        $ht->alamat_jemput = $data["alamat"];
        $ht->durasi = $data["durasi"];
        $ht->status_htrans = "Menunggu Ketersediaan";
        $ht->save();

        return $ht->id_htrans;
    }
}
