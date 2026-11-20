<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('floors', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('building_id')
                ->constrained('buildings')
                ->restrictOnDelete();

            $table->string('code', 30);
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['building_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('floors');
    }
};
