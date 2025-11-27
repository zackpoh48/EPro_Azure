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
        Schema::create("purchase_quote_lines", function (Blueprint $table) {
            $table->id();
            $table->foreignId("purchase_quote_id");
            $table->string("purchase_quote_no");
            $table->integer("line_no")->nullable();
            $table->string("type")->nullable();
            $table->string("description")->nullable();
            $table->float("quantity")->nullable();
            $table->string("unit_of_measure_code")->nullable();
            $table->float("direct_unit_cost")->nullable();
            $table->float("line_amount")->nullable();
            $table
                ->foreign("purchase_quote_id")
                ->references("id")
                ->on("purchase_quotes")
                ->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("purchase_quote_lines");
    }
};
