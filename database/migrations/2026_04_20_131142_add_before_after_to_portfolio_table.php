<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolio', function (Blueprint $table) {
            $table->boolean('is_before')->default(false)->after('category_id');
            $table->foreignId('after_image_id')->nullable()->after('is_before')
                ->constrained('portfolio')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('portfolio', function (Blueprint $table) {
            $table->dropForeign(['after_image_id']);
            $table->dropColumn(['is_before', 'after_image_id']);
        });
    }
};