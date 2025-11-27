<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table("delivery_order_lines", function (Blueprint $table) {
            $table->integer("line_no")->after("purchase_order_no");
            $table->string("type")->after("line_no");
            $table->string("no")->after("type");
            $table
                ->string("location_code")
                ->nullable()
                ->after("description");
            $table
                ->float("quantity_invoiced")
                ->nullable()
                ->after("outstanding_amount");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("delivery_order_lines", function (Blueprint $table) {
            $table->dropColumn("line_No");
            $table->dropColumn("type");
            $table->dropColumn("no");
            $table->dropColumn("location_code");
            $table->dropColumn("quantity_invoiced");
        });
    }
};
