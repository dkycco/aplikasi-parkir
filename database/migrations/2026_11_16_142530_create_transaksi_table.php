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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kendaraan')->contrained('kendaraan');
            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar')->nullable();
            $table->foreignId('id_tarif')->contrained('tarif');
            $table->integer('durasi');
            $table->decimal('biaya_total', 0, 0);
            $table->enum('status', ['masuk', 'keluar']);
            $table->foreignId('id_user')->contrained('users');
            $table->foreignId('id_area')->contrained('area');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
