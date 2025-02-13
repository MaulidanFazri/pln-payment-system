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
        Schema::create('pemakaians', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('no_kontrol');
            $table->integer('tahun');
            $table->integer('bulan');
            $table->integer('meter_awal')->nullable();
            $table->integer('meter_akhir');
            $table->integer('jumlah_pakai')->nullable();
            $table->decimal('biaya_beban',15, 2)->nullable();
            $table->decimal('biaya_pemakaian', 15, 2)->nullable();
            $table->decimal('total_bayar',20, 2)->nullable();
            $table->timestamps();

            // Foreign key ke tabel pelanggan
            $table->foreign('no_kontrol')->references('no_kontrol')->on('pelanggans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemakaians');
    }
};
