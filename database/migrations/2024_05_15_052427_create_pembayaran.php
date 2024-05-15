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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->integerIncrements("id_bayar");
            $table->unsignedInteger("fk_id_htrans");
            $table->date("tanggal");
            $table->string("persen", 15);
            $table->integer("jumlah");
            $table->string("bukti");
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('fk_id_htrans')
                  ->references('id_htrans')
                  ->on('htrans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
