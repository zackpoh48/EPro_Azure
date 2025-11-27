<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuotationFilesInRfqSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rfq_submissions', function (Blueprint $table) {
            $table->longText('quotation_files')->after('expected_delivery')->nullable();
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
            $table->dropColumn('quotation_files');
        });
    }
}
