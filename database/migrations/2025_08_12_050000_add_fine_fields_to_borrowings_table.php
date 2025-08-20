<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->decimal('fine_amount', 10, 2)->default(0)->after('return_notes');
            $table->boolean('fine_paid')->default(false)->after('fine_amount');
            $table->dateTime('fine_paid_at')->nullable()->after('fine_paid');
        });
    }

    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropColumn(['fine_amount', 'fine_paid', 'fine_paid_at']);
        });
    }
};
