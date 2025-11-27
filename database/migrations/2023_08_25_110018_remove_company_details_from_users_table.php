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
        Schema::table("users", function (Blueprint $table) {
            $table->dropUnique(["email", "vendor_no"]);
            $table->unique(["email"]);
            $table->dropColumn("vendor_no");
            $table->dropColumn("company_name");
            $table->dropColumn("company_reg_no");
            $table->dropColumn("type");
            $table->dropColumn("registered_address_one");
            $table->dropColumn("registered_address_two");
            $table->dropColumn("mailing_address_one");
            $table->dropColumn("mailing_address_two");
            $table->dropColumn("city");
            $table->dropColumn("state");
            $table->dropColumn("zip_code");
            $table->dropColumn("country");
            $table->dropColumn("tel_no");
            $table->dropColumn("fax_no");
            $table->dropColumn("company_website");
            $table->dropColumn("type_of_company");
            $table->dropColumn("type_of_company_other");
            $table->dropColumn("date_of_incorporation");
            $table->dropColumn("sst_registration_no");
            $table->dropColumn("contact_person_one");
            $table->dropColumn("designation_one");
            $table->dropColumn("contact_person_two");
            $table->dropColumn("designation_two");
            $table->dropColumn("contact_person_three");
            $table->dropColumn("designation_three");
            $table->dropColumn("latest_business_registration_files");
            $table->dropColumn("borang_p_files");
            $table->dropColumn("form_49_files");
            $table->dropColumn("photocopy_ic_files");
            $table->dropColumn("bank_name");
            $table->dropColumn("bank_branch");
            $table->dropColumn("bank_account_no");
            $table->dropColumn("swift_code");
            $table->dropColumn("bank_address_one");
            $table->dropColumn("bank_address_two");
            $table->dropColumn("bank_statement_attachments");
            $table->dropColumn("credit_term_offered");
            $table->dropColumn("credit_term_offered_other");
            $table->dropColumn("is_print");
            $table->dropColumn("is_complete");
            $table->dropColumn("attempts");
            $table->dropColumn("nav_status");
            $table->dropColumn("fault_code");
            $table->dropColumn("soap_data");
            $table->dropColumn("status");
            $table->dropColumn("completed_at");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("users", function (Blueprint $table) {
            $table->after("registered_email_address", function ($table) {
                $table->string("vendor_no");
                $table->string("company_name", 50);
                $table->string("company_reg_no", 20)->nullable();
                $table->integer("type")->default(1);
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
                $table
                    ->longText("latest_business_registration_files")
                    ->nullable();
                $table->longText("borang_p_files")->nullable();
                $table->longText("form_49_files")->nullable();
                $table->longText("photocopy_ic_files")->nullable();
                $table->string("bank_name")->nullable();
                $table->string("bank_branch")->nullable();
                $table->string("bank_account_no")->nullable();
                $table->string("swift_code")->nullable();
                $table->string("bank_address_one", 50)->nullable();
                $table->string("bank_address_two", 50)->nullable();
                $table->longText("bank_statement_attachments")->nullable();
                $table->string("credit_term_offered")->nullable();
                $table->string("credit_term_offered_other")->nullable();
                $table->integer("is_print")->default("0");
                $table->integer("is_complete")->default("0");
                $table->unsignedTinyInteger("attempts")->default("0");
                $table->string("nav_status")->default("created");
                $table->longText("fault_code")->nullable();
                $table->longText("soap_data")->nullable();
                $table->integer("status")->default(StatusEnum::Draft->value);
                $table->foreignId("organization_id");
                $table->timestamp("completed_at")->nullable();
            });
            $table->dropUnique(["email"]);
            $table->unique(["email", "vendor_no"]);
        });
    }
};
