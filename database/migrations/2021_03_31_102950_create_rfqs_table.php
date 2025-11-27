<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfqs', function (Blueprint $table) {
            $table->id();
            $table->string('rfq_id')->unique();
            $table->string('tender_title')->nullable();
            $table->date('date_of_rfq')->format('d/m/Y');
            $table->string('priority', 10)->nullable();
            $table->date('date_of_expiry')->format('d/m/Y');
            $table->string('quotation_no')->nullable();
            $table->binary('buyer_remarks')->nullable();
            $table->string('delivery_code')->nullable();
            $table->string('currency')->nullable();
            $table->string('delivery_location')->nullable();
            $table->boolean('status');
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('rfqs');
    }
}
