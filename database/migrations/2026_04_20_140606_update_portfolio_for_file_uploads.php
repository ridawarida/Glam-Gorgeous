<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolio', function (Blueprint $table) {
            // Rename image_url to image_path for clarity
            $table->renameColumn('image_url', 'image_path');
        });
    }

    public function down(): void
    {
        Schema::table('portfolio', function (Blueprint $table) {
            $table->renameColumn('image_path', 'image_url');
        });
    }
};