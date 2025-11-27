<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVendorQuotationNoRfqSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rfq_submissions', function (Blueprint $table) {
            $table->longText('vendor_quotation_no')->after('advance_paid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rfq_submissions', function (Blueprint $table) {
            //
        });
    }
}
