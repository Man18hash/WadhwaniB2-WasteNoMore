<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weekly_statistics', function (Blueprint $table) {
            $table->decimal('paper_waste_kg', 10, 2)->default(0)->after('plastic_waste_kg');
        });
    }

    public function down(): void
    {
        Schema::table('weekly_statistics', function (Blueprint $table) {
            $table->dropColumn('paper_waste_kg');
        });
    }
};