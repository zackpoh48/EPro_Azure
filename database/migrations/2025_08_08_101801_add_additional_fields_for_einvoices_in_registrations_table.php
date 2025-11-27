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
        Schema::table('registrations', function (Blueprint $table) {
            $table->enum('vendor_type', ['Local', 'Foreign'])
                ->after('organization_id');

            $table->string('msic_code')->nullable()->after('vendor_type');

            $table->enum('id_type', ['NRIC', 'PASSPORT', 'BRN', 'ARMY'])
                ->after('msic_code')
                ->default('BRN');

            $table->string('tin', 55)
                ->nullable()
                ->after('id_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['vendor_type', 'msic_code', 'id_type', 'tin']);
        });
    }
};
