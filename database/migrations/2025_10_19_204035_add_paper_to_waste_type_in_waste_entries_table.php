<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // For SQLite, we need to recreate the table with the new enum values
        if (DB::getDriverName() === 'sqlite') {
            // Create a temporary table with the new structure
            Schema::create('waste_entries_temp', function (Blueprint $table) {
                $table->id();
                $table->date('entry_date');
                $table->enum('waste_type', ['vegetable', 'fruit', 'plastic', 'paper']);
                $table->decimal('weight_kg', 10, 2);
                $table->enum('processing_technology', [
                    'anaerobic',
                    'bsf',
                    'activated',
                    'paper',
                    'pyrolysis'
                ]);
                $table->text('notes')->nullable();
                $table->timestamps();
                
                $table->index('entry_date');
                $table->index('waste_type');
            });

            // Copy data from old table to new table
            DB::statement('INSERT INTO waste_entries_temp SELECT * FROM waste_entries');

            // Drop old table
            Schema::dropIfExists('waste_entries');

            // Rename new table
            Schema::rename('waste_entries_temp', 'waste_entries');
        } else {
            // For MySQL/PostgreSQL, we can use ALTER TABLE
            DB::statement("ALTER TABLE waste_entries MODIFY COLUMN waste_type ENUM('vegetable', 'fruit', 'plastic', 'paper')");
        }
    }

    public function down(): void
    {
        // For SQLite, we need to recreate the table with the old enum values
        if (DB::getDriverName() === 'sqlite') {
            // Create a temporary table with the old structure
            Schema::create('waste_entries_temp', function (Blueprint $table) {
                $table->id();
                $table->date('entry_date');
                $table->enum('waste_type', ['vegetable', 'fruit', 'plastic']);
                $table->decimal('weight_kg', 10, 2);
                $table->enum('processing_technology', [
                    'anaerobic',
                    'bsf',
                    'activated',
                    'paper',
                    'pyrolysis'
                ]);
                $table->text('notes')->nullable();
                $table->timestamps();
                
                $table->index('entry_date');
                $table->index('waste_type');
            });

            // Copy data from old table to new table (excluding paper entries)
            DB::statement("INSERT INTO waste_entries_temp SELECT * FROM waste_entries WHERE waste_type != 'paper'");

            // Drop old table
            Schema::dropIfExists('waste_entries');

            // Rename new table
            Schema::rename('waste_entries_temp', 'waste_entries');
        } else {
            // For MySQL/PostgreSQL, we can use ALTER TABLE
            DB::statement("ALTER TABLE waste_entries MODIFY COLUMN waste_type ENUM('vegetable', 'fruit', 'plastic')");
        }
    }
};