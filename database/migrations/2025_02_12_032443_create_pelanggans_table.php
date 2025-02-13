<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->string('no_kontrol')->primary();
            $table->string('nama');
            $table->text('alamat');
            $table->string('telepon');
            $table->string('jenis_plg');  // Tipe dan panjang sama dengan tabel tarif
            $table->foreign('jenis_plg')->references('jenis_plg')->on('tarifs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
