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
        Schema::table('updated_vendor_profiles', function () {
            DB::statement('ALTER TABLE `updated_vendor_profiles` CHANGE `email` `username` VARCHAR(255)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('updated_vendor_profiles', function () {
            DB::statement('ALTER TABLE `updated_vendor_profiles` CHANGE `username` `email` VARCHAR(255)');
        });
    }
};
