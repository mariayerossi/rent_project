<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('htrans', function (Blueprint $table) {
            $table->integerIncrements("id_htrans");
            $table->timestamp("tanggal_htrans");
            $table->string("nama_cust");
            $table->string("telepon_cust");
            $table->string("jenis");
            $table->date("tanggal_jemput");
            $table->time("jam_jemput");
            $table->string("alamat_jemput");
            $table->integer("durasi");
            $table->integer("harga_jenis");
            $table->integer("subtotal_jenis");
            $table->integer("subtotal_mobil");
            $table->integer("total");
            $table->string("status_htrans");//menunggu, diterima, ditolak (pengembalian uang melalui whatsapp)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('htrans');
    }
};
