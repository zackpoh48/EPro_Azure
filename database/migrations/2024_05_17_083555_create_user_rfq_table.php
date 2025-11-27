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
        Schema::create('user_rfqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->foreignId("rfq_id");
            $table->timestamps();
            $table->unique(["user_id", "rfq_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_rfqs');
    }
};
