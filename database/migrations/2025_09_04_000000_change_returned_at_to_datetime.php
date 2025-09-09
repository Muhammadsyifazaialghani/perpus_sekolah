<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL to change column type since Laravel's change() method has limitations
        DB::statement('ALTER TABLE borrowings MODIFY COLUMN returned_at TIMESTAMP NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to date type
        DB::statement('ALTER TABLE borrowings MODIFY COLUMN returned_at DATE NULL');
    }
};
