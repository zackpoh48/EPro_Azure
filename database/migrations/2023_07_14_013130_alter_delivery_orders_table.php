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
        Schema::table("delivery_orders", function (Blueprint $table) {
            //Change string to date
            $table
                ->date("order_date")
                ->nullable()
                ->after("invoice_attachments");
            $table
                ->date("expected_receipt_date")
                ->nullable()
                ->after("order_date");
            $table
                ->float("amount_including_vat")
                ->nullable()
                ->after("expected_receipt_date");
            $table
                ->string("currency_code")
                ->nullable()
                ->after("amount_including_vat");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("delivery_orders", function (Blueprint $table) {
            $table->dropColumn("order_date");
            $table->dropColumn("expected_receipt_date");
            $table->dropColumn("amount_including_vat");
            $table->dropColumn("currency_code");
        });
    }
};
