<?php

use App\Enum\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("users", function (Blueprint $table) {
            $table->id();
            $table->uuid("unique_id");
            $table->string("name", 30);
            $table->string("email", 80)->unique();
            $table->string("registered_email_address", 80)->nullable();
            $table->string("vendor_no");
            $table->string("company_name", 50);
            $table->string("company_reg_no", 20)->nullable();
            $table->string("registered_address_one", 50)->nullable();
            $table->string("registered_address_two", 50)->nullable();
            $table->string("mailing_address_one", 50)->nullable();
            $table->string("mailing_address_two", 50)->nullable();
            $table->string("city", 30)->nullable();
            $table->string("state", 30)->nullable();
            $table->string("zip_code", 20)->nullable();
            $table->string("country", 10)->nullable();
            $table->string("tel_no", 30)->nullable();
            $table->string("fax_no", 30)->nullable();
            $table->string("company_website", 80)->nullable();
            $table->string("type_of_company")->nullable();
            $table->string("type_of_company_other")->nullable();
            $table->date("date_of_incorporation")->nullable();
            $table->string("sst_registration_no", 20)->nullable();
            $table->string("contact_person_one", 30)->nullable();
            $table->string("designation_one", 30)->nullable();
            $table->string("contact_person_two", 30)->nullable();
            $table->string("designation_two", 30)->nullable();
            $table->string("contact_person_three", 30)->nullable();
            $table->string("designation_three", 30)->nullable();
            $table->longText("latest_business_registration_files")->nullable();
            $table->longText("borang_p_files")->nullable();
            $table->longText("form_49_files")->nullable();
            $table->longText("photocopy_ic_files")->nullable();
            $table->string("bank_name")->nullable();
            $table->string("bank_branch")->nullable();
            $table->string("bank_account_no")->nullable();
            $table->string("swift_code")->nullable();
            $table->longText("bank_statement_attachments")->nullable();
            // $table->longText("product_files")->nullable();
            // $table->string("product_catalogue")->nullable();
            // $table->string("product_desc_one", 50)->nullable();
            // $table->string("product_desc_two", 50)->nullable();
            // $table->string("product_desc_three", 50)->nullable();
            // $table->string("product_desc_four", 50)->nullable();
            // $table->string("product_desc_five", 50)->nullable();
            // $table->string("product_desc_six", 50)->nullable();
            $table->string("credit_term_offered")->nullable();
            $table->string("credit_term_offered_other")->nullable();
            $table->string("anti_bribery_acknowledgement")->nullable();
            // $table->string("designation", 30)->nullable();
            // $table->string("nric_no", 14)->nullable();
            // $table->date("date")->nullable();
            $table->integer("is_print")->default("0");
            $table->integer("is_print_upload")->default("0");
            $table->integer("is_complete")->default("0");
            $table->string("supplier_pdf")->nullable();
            $table->unsignedTinyInteger("attempts")->default("0");
            $table->string("nav_status")->default("created");
            $table->longText("fault_code")->nullable();
            $table->longText("soap_data")->nullable();
            $table->integer("status")->default(StatusEnum::Draft->value);
            $table->string("password");
            $table->foreignId("organization_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("users");
    }
};
