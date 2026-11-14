<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Nomor transaksi utama
            $table->string('order_number', 50)->unique();

            // Pelanggan dapat memesan tanpa login
            $table->foreignUuid('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Jenis layanan
            $table->string('service_type', 30);

            // Informasi meja untuk Dine In
            $table->string('table_code', 30)->nullable();
            $table->string('table_name', 100)->nullable();

            // Jadwal pengambilan untuk After Event
            $table->date('pickup_date')->nullable();
            $table->time('pickup_time')->nullable();

            // Informasi pelanggan
            $table->string('customer_name', 150)->nullable();
            $table->string('customer_phone', 30)->nullable();

            // Catatan pesanan
            $table->text('notes')->nullable();

            // Status transaksi utama
            $table->string('status', 30)
                ->default('pending');

            // Nilai transaksi
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);

            $table->timestamps();

            // Index untuk pencarian dan pemantauan transaksi
            $table->index(['status', 'created_at']);
            $table->index('service_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};