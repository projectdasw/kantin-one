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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Pengguna yang melakukan aktivitas.
            $table->foreignUuid('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Informasi aktivitas.
            $table->string('activity', 100);
            $table->text('description')->nullable();

            // Objek yang terpengaruh.
            $table->string('subject_type')->nullable();
            $table->uuid('subject_id')->nullable();

            // Detail perubahan sebelum dan sesudah.
            $table->json('properties')->nullable();

            // Informasi perangkat dan akses.
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('url')->nullable();
            $table->string('method', 10)->nullable();

            $table->timestamp('created_at')->useCurrent();

            // Index pencarian histori.
            $table->index('user_id');
            $table->index('activity');
            $table->index(['subject_type', 'subject_id']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};