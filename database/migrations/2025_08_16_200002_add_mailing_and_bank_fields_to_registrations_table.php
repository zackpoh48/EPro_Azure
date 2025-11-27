<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Mailing address
            $table->string('mailing_address_city', 50)->nullable();
            $table->string('mailing_address_state', 50)->nullable();
            $table->string('mailing_address_zip_code', 50)->nullable();
            $table->string('mailing_address_country', 50)->nullable();
            $table->boolean('mailing_address_same_as_registered_address')->default(false);

            // Bank details
            $table->string('bank_name', 255)->nullable();
            $table->string('bank_branch', 255)->nullable();
            $table->string('bank_account_no', 255)->nullable();
            $table->string('swift_code', 255)->nullable();
            $table->string('bank_address_one', 50)->nullable();
            $table->string('bank_address_two', 50)->nullable();
            $table->longText('bank_statement_attachments')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn([
                'mailing_address_city',
                'mailing_address_state',
                'mailing_address_zip_code',
                'mailing_address_country',
                'mailing_address_same_as_registered_address',
                'bank_name',
                'bank_branch',
                'bank_account_no',
                'swift_code',
                'bank_address_one',
                'bank_address_two',
                'bank_statement_attachments',
            ]);
        });
    }
};
