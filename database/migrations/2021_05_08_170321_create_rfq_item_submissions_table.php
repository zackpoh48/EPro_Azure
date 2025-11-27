<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqItemSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_item_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('rfq_id');
            $table->foreignId('rfq_submission_id')->constrained('rfq_submissions');
            $table->string('item_description', 50)->nullable();
            $table->string('s_no', 20)->nullable();
            $table->string('item_no', 20)->nullable();
            $table->string('item_expected_delivery')->format('d/M/y')->nullable();
            $table->string('quality')->nullable();
            $table->string('qty')->nullable();
            $table->string('uom')->nullable();
            $table->decimal('offer_qty')->nullable();
            $table->string('offer_uom',10)->nullable();
            $table->decimal('cost')->nullable();
            $table->decimal('discount')->default('0');
            $table->binary('remarks')->nullable();
            $table->tinyInteger('is_submitting');
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
        Schema::dropIfExists('rfq_item_submissions');
    }
}
