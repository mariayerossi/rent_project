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
        Schema::create('ketersediaan', function (Blueprint $table) {
            $table->integerIncrements("id_sedia");
            $table->unsignedInteger("fk_id_mobil");
            $table->date("tanggal_mulai");
            $table->date("tanggal_selesai");
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('fk_id_mobil')
                  ->references('id_mobil')
                  ->on('mobil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ketersediaan');
    }
};
