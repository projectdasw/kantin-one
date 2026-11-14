<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('order_id')
                ->constrained('orders')
                ->restrictOnDelete();

            $table->foreignUuid('tenant_id')
                ->constrained('tenants')
                ->restrictOnDelete();

            $table->string('order_number', 50)->unique();
            $table->string('pickup_code', 20)->unique();

            $table->string('status', 30)->default('pending');

            $table->decimal('subtotal', 15, 2)->default(0);

            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            $table->unique(['order_id', 'tenant_id']);

            $table->index(['tenant_id', 'status']);
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_orders');
    }
};