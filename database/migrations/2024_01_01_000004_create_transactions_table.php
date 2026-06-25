<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->decimal('berat', 8, 2);
            $table->unsignedInteger('total_harga');
            $table->string('status')->default('Diproses'); // Diproses, Siap Diambil, Selesai
            $table->dateTime('tanggal_masuk');
            $table->dateTime('tanggal_estimasi');
            $table->dateTime('tanggal_diambil')->nullable();
            $table->string('status_pembayaran')->default('Belum Lunas'); // Belum Lunas, Lunas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
