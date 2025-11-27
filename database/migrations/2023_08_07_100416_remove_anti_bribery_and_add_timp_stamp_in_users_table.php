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
        Schema::table("users", function (Blueprint $table) {
            $table->dropColumn("anti_bribery_acknowledgement");
            $table->dropColumn("is_print_upload");
            $table->dropColumn("supplier_pdf");
            $table
                ->timestamp("completed_at")
                ->nullable()
                ->after("organization_id");
            $table
                ->boolean("is_password_updated")
                ->default(false)
                ->after("status");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("users", function (Blueprint $table) {
            $table
                ->string("anti_bribery_acknowledgement")
                ->nullable()
                ->after("credit_term_offered_other");
            $table->dropColumn("completed_at");
            $table->dropColumn("is_first_time_login");
            $table
                ->integer("is_print_upload")
                ->after("is_print")
                ->default("0");
            $table
                ->string("supplier_pdf")
                ->nullable()
                ->after("is_complete");
        });
    }
};
