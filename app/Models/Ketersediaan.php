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

    public function get_by_id_mobil($id){
        return Ketersediaan::where("deleted_at","=",null)->where("fk_id_mobil","=",$id)->get();
    }

    public function deleteKetersediaan($data)
    {
        $sed = Ketersediaan::find($data["id"]);
        $sed->delete();
    }
}
