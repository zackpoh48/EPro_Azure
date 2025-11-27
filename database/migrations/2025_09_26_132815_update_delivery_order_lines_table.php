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
            $table->boolean('progress_billing')->default(0)->after('quantity_invoiced');
            $table->decimal('progress_billing_amount', 15, 2)->default(0)->after('progress_billing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_order_lines', function (Blueprint $table) {
            $table->dropColumn('progress_billing');
            $table->dropColumn('progress_billing_amount');
        });
    }
};
