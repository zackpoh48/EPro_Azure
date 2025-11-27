<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('delivery_order_lines', function (Blueprint $table) {
            $table->string("unit_of_measure_code", 55)->nullable()->after("type");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_order_lines', function (Blueprint $table) {
            $table->dropColumn('unit_of_measure_code');
        });
    }
};
