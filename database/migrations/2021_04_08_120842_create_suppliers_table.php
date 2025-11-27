<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->integer('invite_id');
            $table->uuid('unique_id')->unique();
            $table->string('name_of_company', 50)->nullable();
            $table->string('company_reg_no', 20)->nullable();
            $table->string('person_name', 50)->nullable();
            $table->string('reference', 50)->nullable();
            $table->foreignId('organization_id');
            $table->string('registered_address_one', 50)->nullable();
            $table->string('registered_address_two', 50)->nullable();
            $table->string('mailing_address_one', 50)->nullable();
            $table->string('mailing_address_two', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('zip_code', 50)->nullable();
            $table->string('country', 50)->nullable()->default('Malaysia');
            $table->string('tel_no', 30)->nullable();
            $table->string('fax_no', 30)->nullable();
            $table->string('company_website', 80)->nullable();
            $table->string('email_address', 80)->nullable();
            $table->string('type_of_company')->nullable();
            $table->string('type_of_company_other')->nullable();
            $table->date('date_of_incorporation')->format('d/m/Y')->nullable();
            $table->decimal('year_in_operation')->nullable();
            $table->string('sst_registration_no', 20)->nullable();
            $table->string('contact_person_one', 30)->nullable();
            $table->string('designation_one', 30)->nullable();
            $table->string('contact_person_two', 30)->nullable();
            $table->string('designation_two', 30)->nullable();
            $table->string('contact_person_three', 30)->nullable();
            $table->string('designation_three', 30)->nullable();
            $table->longText('company_profile_files')->nullable();
            $table->decimal('annual_turnover', 16, 2)->nullable();
            $table->decimal('working_capital', 16, 2)->nullable();
            $table->decimal('net_worth', 16, 2)->nullable();
            $table->decimal('cash_bank_balance', 16, 2)->nullable();
            $table->decimal('paid_up_capital', 16, 2)->nullable();
            $table->longText('product_files')->nullable();
            $table->string('product_catalogue')->nullable();
            $table->string('product_desc_one', 50)->nullable();
            $table->string('product_desc_two', 50)->nullable();
            $table->string('product_desc_three', 50)->nullable();
            $table->string('product_desc_four', 50)->nullable();
            $table->string('product_desc_five', 50)->nullable();
            $table->string('product_desc_six', 50)->nullable();
            $table->string('credit_term_offered')->nullable();
            $table->string('credit_term_offered_other')->nullable();
            $table->string('certification')->nullable();
            $table->string('certification_other')->nullable();
            $table->longText('certification_files')->nullable();
            $table->string('litigation_records')->nullable();
            $table->string('litigation_records_other')->nullable();
            $table->string('corruption_fraudulent_records')->nullable();
            $table->string('corruption_fraudulent_records_other')->nullable();
            $table->string('declaration_by_supplier')->nullable();
            $table->string('authorized_company_director')->nullable();
            $table->string('name', 30)->nullable();
            $table->string('designation', 30)->nullable();
            $table->string('nric_no', 14)->nullable();
            $table->date('date')->format('d/m/Y')->nullable();
            $table->integer('is_print')->default('0');
            $table->integer('is_print_upload')->default('0');
            $table->integer('is_complete')->default('0');
            $table->string('supplier_pdf')->nullable();
            $table->integer('status');
            $table->string('nav_status')->default('created');
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->longText('fault_code')->nullable();
            $table->longText('soap_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
}
