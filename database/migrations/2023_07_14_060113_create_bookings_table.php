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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('gedung_id')->constrained('gedung')->onDelete('cascade');
            $table->string('no_telp');
            $table->date('tanggal');
            $table->bigInteger('harga_total');
            $table->string('image')->nullable();
            $table->enum('status', ['Belum Dibayar', 'Menunggu', 'Selesai', 'Cancel'])->default('Belum Dibayar');
            $table->timestamps();

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
