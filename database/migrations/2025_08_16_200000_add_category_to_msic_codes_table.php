<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // If you already have data, keep it nullable first to avoid failures.
    public function up(): void
    {
        Schema::table('msic_codes', function (Blueprint $table) {
            // Adjust length if you know your max category size
            $table->string('category', 100)->nullable()->index();
            // If you want a specific position in MySQL, uncomment and tweak:
            // ->after('some_existing_column');
        });
    }

    public function down(): void
    {
        Schema::table('msic_codes', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
