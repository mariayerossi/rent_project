<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dtrans extends Model
{
    use HasFactory;
    //-------- !HARUS ADA! ------------
    protected $table ="dtrans";//diganti dengan nama table di database
    protected $primaryKey ="id_dtrans";//diganti dengan nama primary key dari table
    public $timestamp = true; //klo true otomatis akan nambah field create_at dan update_at
    public $incrementing = true;//utk increment
    //---------------------------------

    public function insertDtrans($data)
    {
        $dt = new Dtrans();
        $dt->fk_id_htrans = $data["fk_id_htrans"];
        $dt->fk_id_mobil = $data["fk_id_mobil"];
        $dt->status_dtrans = "Dalam Pengecekan";
        $dt->save();
    }
}
