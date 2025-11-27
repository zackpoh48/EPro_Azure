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
        Schema::table('status_logs', function (Blueprint $table) {
            // Make user_id nullable
            $table->foreignId('user_id')->nullable()->change();

            // Add admin_id foreign key, nullable
            $table->foreignId('admin_id')->nullable()->constrained('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_logs', function (Blueprint $table) {
            // Revert user_id back to not nullable
            $table->foreignId('user_id')->nullable(false)->change();

            // Drop the foreign key and column admin_id
            $table->dropForeign(['admin_id']);
            $table->dropColumn('admin_id');
        });
    }
};
