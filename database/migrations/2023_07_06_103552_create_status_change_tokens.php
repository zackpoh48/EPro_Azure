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
        Schema::create("status_change_tokens", function (Blueprint $table) {
            $table->string("email");
            $table->string("vendor_no");
            $table->string("token");
            $table->timestamp("created_at")->nullable();
            $table->unique(["email", "vendor_no"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("status_change_tokens");
    }
};
