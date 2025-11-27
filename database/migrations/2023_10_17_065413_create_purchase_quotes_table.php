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
        Schema::create("purchase_quotes", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->foreignId("company_id");
            $table->foreignId("organization_id");
            $table->string("vendor_no")->nullable();
            $table->string("purchase_quote_no");
            $table->date("date");
            $table->string("vendor_quote_no")->nullable();
            $table->date("quotation_date")->nullable();
            $table->string("currency")->nullable();
            $table->float("amount_including_sst")->nullable();
            $table->string("reference")->nullable();
            $table->longText("support_attachments")->nullable();
            $table->integer("last_line_no")->nullable();
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
        Schema::dropIfExists("purchase_quotes");
    }
};
