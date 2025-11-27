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
        Schema::create("delivery_orders", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table
                ->string("delivery_order_no")
                ->unique()
                ->nullable();
            $table->date("delivery_order_date")->nullable();
            $table->string("purchase_order_no");
            $table->longText("delivery_attachments")->nullable();
            $table->string("invoice_no")->nullable();
            $table->date("invoice_date")->nullable();
            $table->longText("invoice_attachments")->nullable();
            $table->boolean("is_complete");
            $table->string("nav_status")->default("created");
            $table->unsignedTinyInteger("attempts")->default(0);
            $table->longText("fault_code")->nullable();
            $table->longText("soap_data")->nullable();
            $table
                ->foreign("user_id")
                ->references("id")
                ->on("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("delivery_order_lines");
        Schema::dropIfExists("delivery_orders");
    }
};
