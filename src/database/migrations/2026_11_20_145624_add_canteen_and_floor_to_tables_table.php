<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->foreignUuid('canteen_id')
                ->nullable()
                ->constrained('canteens')
                ->restrictOnDelete();

            $table->foreignUuid('floor_id')
                ->nullable()
                ->constrained('floors')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropForeign(['canteen_id']);
            $table->dropForeign(['floor_id']);

            $table->dropColumn(['canteen_id', 'floor_id']);
        });
    }
};
