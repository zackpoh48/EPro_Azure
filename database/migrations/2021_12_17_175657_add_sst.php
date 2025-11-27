<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSst extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rfq_item_submissions', function (Blueprint $table) {
            $table->string('sst',30)->after('discount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rfq_item_submissions', function (Blueprint $table) {
            $table->dropColumn('sst');
        });
    }
}
