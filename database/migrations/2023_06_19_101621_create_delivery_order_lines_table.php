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
        Schema::create("delivery_order_lines", function (Blueprint $table) {
            $table->id();
            $table->foreignId("delivery_order_id");
            $table->string("purchase_order_no");
            $table->string("description")->nullable();
            $table->float("quantity")->nullable();
            $table->float("unit_cost_including_sst")->nullable();
            $table->float("amount_including_sst")->nullable();
            $table->float("quantity_to_deliver")->nullable();
            $table->float("quantity_delivered")->nullable();
            $table->float("outstanding_quantity")->nullable();
            $table->boolean("deliver_with_amount")->nullable();
            $table->float("amount_to_deliver_including_sst")->nullable();
            $table->float("amount_delivered")->nullable();
            $table->float("outstanding_amount")->nullable();
            $table
                ->foreign("delivery_order_id")
                ->references("id")
                ->on("delivery_orders")
                ->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("delivery_order_lines");
    }
};
