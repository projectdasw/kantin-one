<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code', 20)->unique();
            $table->string('name', 100);
            $table->unsignedSmallInteger('capacity')->default(4);
            $table->string('location', 100)->nullable();
            $table->string('qr_token', 64)->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->index('is_active');
            $table->index('location');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
