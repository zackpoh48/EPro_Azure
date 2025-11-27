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
        Schema::table("companies", function (Blueprint $table) {
            $table->string("vendor_type")->nullable();
            $table->string("tin")->nullable();
            $table->string("msic_code")->nullable();
            $table->string("id_type")->nullable();
            $table->string("id_value")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("companies", function (Blueprint $table) {
            $table->dropColumn([
                "vendor_type",
                "tin",
                "msic_code",
                "id_type",
                "id_value",
            ]);
        });
    }
};
