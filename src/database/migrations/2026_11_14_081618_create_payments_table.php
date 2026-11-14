<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Transaksi utama yang dibayar
            $table->foreignUuid('order_id')
                ->constrained('orders')
                ->restrictOnDelete();

            // Metode pembayaran
            $table->string('payment_method', 30);

            // Jumlah pembayaran
            $table->decimal('amount', 15, 2);

            // Status pembayaran
            $table->string('status', 30)->default('pending');

            // Referensi transaksi dari payment gateway
            $table->string('transaction_reference', 150)->nullable();
            $table->string('provider', 100)->nullable();

            // Informasi waktu pembayaran
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            // Informasi kegagalan pembayaran
            $table->text('failure_reason')->nullable();

            // Metadata tambahan dari payment gateway
            $table->jsonb('metadata')->nullable();

            $table->timestamps();

            $table->index(['order_id', 'status']);
            $table->index('transaction_reference');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};