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
            $table
                ->string("bank_address_one", 50)
                ->nullable()
                ->after("swift_code");
            $table
                ->string("bank_address_two", 50)
                ->nullable()
                ->after("bank_address_one");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("users", function (Blueprint $table) {
            $table->dropColumn("bank_address_one");
            $table->dropColumn("bank_address_two");
        });
    }
};
