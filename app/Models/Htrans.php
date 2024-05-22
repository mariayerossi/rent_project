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
        $ht->telepon_cust = $data["telepon"];
        $ht->jenis = $data["jenis"];
        $ht->tanggal_jemput = $data["tanggal_jem"];
        $ht->jam_jemput = $data["jam"];
        $ht->alamat_jemput = $data["alamat"];
        $ht->durasi = $data["durasi"];
        $ht->harga_jenis = $data["harga"];
        $ht->subtotal_jenis = $data["sub_jenis"];
        $ht->subtotal_mobil = $data["sub_mobil"];
        $ht->total = $data["total"];
        $ht->status_htrans = "Menunggu";
        $ht->save();

        return $ht->id_htrans;
    }

    public function get_all_data(){
        return Htrans::where('deleted_at',"=",null)->get();
    }

    public function get_all_data_menunggu(){
        return Htrans::where('deleted_at',"=",null)->where("status_htrans","=","Menunggu")->get();
    }

    public function get_all_data_lunas(){
        return Htrans::where('deleted_at',"=",null)->where("status_htrans","=","Lunas")->get();
    }

    public function get_all_data_selesai(){
        return Htrans::where('deleted_at',"=",null)->where("status_htrans","=","Selesai")->get();
    }

    public function get_data_by_id($id){
        return Htrans::where("id_htrans","=",$id)->first();
    }

    public function updateStatus($data){
        $ht = Htrans::find($data["id"]);
        $ht->status_htrans = $data["status"];
        $ht->save();
    }
}
