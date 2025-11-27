<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePayModeFromRfqSubmissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rfq_submissions', function (Blueprint $table) {
            $table->dropColumn('pay_mode');
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
            $table->string('pay_mode');
        });
    }
}
