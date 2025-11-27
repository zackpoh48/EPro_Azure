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
        Schema::table("status_change_tokens", function (Blueprint $table) {
            $table->dropUnique(["email", "vendor_no"]);
            $table->dropColumn("email");
            $table->dropColumn("vendor_no");
            $table->foreignId("user_id")->first();
            $table->foreignId("company_id")->after("user_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("status_change_tokens", function (Blueprint $table) {
            $table->string("email")->first();
            $table->string("vendor_no")->after("email");
            $table->dropColumn("user_id");
            $table->dropColumn("company_id");
            $table->unique(["email", "vendor_no"]);
        });
    }
};
