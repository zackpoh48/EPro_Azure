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
        Schema::table("updated_vendor_profiles", function (Blueprint $table) {
            $table->after("user_id", function ($table) {
                $table->foreignId("company_id");
                $table->foreignId("organization_id")->default(1);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("updated_vendor_profiles", function (Blueprint $table) {
            $table->dropColumn("company_id");
            $table->dropColumn("organization_id");
        });
    }
};
