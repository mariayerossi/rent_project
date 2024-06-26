<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ketersediaan extends Model
{
    use HasFactory;
    //-------- !HARUS ADA! ------------
    protected $table ="ketersediaan";//diganti dengan nama table di database
    protected $primaryKey ="id_sedia";//diganti dengan nama primary key dari table
    public $timestamp = true; //klo true otomatis akan nambah field create_at dan update_at
    public $incrementing = true;//utk increment
    //---------------------------------

    public function insertKetersediaan($data)
    {
        $sed = new Ketersediaan();
        $sed->fk_id_mobil = $data["fk_id_mobil"];
        $sed->tanggal_mulai = $data["mulai"];
        $sed->tanggal_selesai = $data["selesai"];
        $sed->save();
    }

    public function get_by_id($id){
        return Ketersediaan::where("id_sedia","=",$id)->first();
    }

    public function get_by_id_mobil($id){
        return Ketersediaan::where("deleted_at","=",null)->where("fk_id_mobil","=",$id)->get();
    }

    public function get_all_data(){
        return Ketersediaan::where("deleted_at","=",null)->get();
    }

    public function deleteKetersediaan($data)
    {
        $sed = Ketersediaan::find($data["id"]);
        $sed->delete();
    }

    public function SoftDeleteKetersediaan($data)
    {
        date_default_timezone_set("Asia/Jakarta");
        $skrg = date("Y-m-d H:i:s");

        $sed = Ketersediaan::find($data["id"]);
        $sed->deleted_at = $skrg;
        $sed->save();
    }

    public function updateKetersediaan($data){
        $sed = Ketersediaan::find($data["id"]);
        $sed->tanggal_mulai = $data["mulai"];
        $sed->tanggal_selesai = $data["selesai"];
        $sed->save();
    }
}
