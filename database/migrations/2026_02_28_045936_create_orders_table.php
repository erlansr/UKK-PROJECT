<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total', 15, 2);
            $table->enum('status', [
                'menunggu_konfirmasi', 
                'diproses', 
                'dikirim', 
                'selesai', 
                'ditolak'
            ])->default('menunggu_konfirmasi');
            $table->text('alamat');
            $table->string('no_hp');
            $table->text('catatan')->nullable();
            $table->string('jasa_pengiriman');
            $table->string('metode_pembayaran');
            $table->boolean('payment_confirmed')->default(false);
            $table->timestamp('payment_confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};