<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            if (!Schema::hasColumn('borrowings', 'book_condition')) {
                $table->string('book_condition')->nullable()->after('status');
            }
            if (!Schema::hasColumn('borrowings', 'return_notes')) {
                $table->text('return_notes')->nullable()->after('book_condition');
            }
            // Kolom returned_at diasumsikan sudah ada, jadi tidak ditambahkan di sini
        });
    }

    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            if (Schema::hasColumn('borrowings', 'book_condition')) {
                $table->dropColumn('book_condition');
            }
            if (Schema::hasColumn('borrowings', 'return_notes')) {
                $table->dropColumn('return_notes');
            }
            // Kolom returned_at tidak dihapus karena sudah ada sebelumnya
        });
    }
};
