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
        Schema::table("organizations", function (Blueprint $table) {
            $table->dropColumn("terms_and_condition_file");
            $table->after("send_registration_email", function ($table) {
                $table->string("nav_username")->nullable();
                $table->string("nav_password")->nullable();
                $table->string("nav_auth")->nullable();
                $table->string("nav_server")->nullable();
                $table->string("nav_port")->nullable();
                $table->string("nav_environment")->nullable();
                $table->string("nav_company")->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("organizations", function (Blueprint $table) {
            $table
                ->longText("terms_and_condition_file")
                ->nullable()
                ->after("send_registration_email");
            $table->dropColumn("nav_username");
            $table->dropColumn("nav_password");
            $table->dropColumn("nav_auth");
            $table->dropColumn("nav_server");
            $table->dropColumn("nav_port");
            $table->dropColumn("nav_environment");
            $table->dropColumn("nav_company");
        });
    }
};
