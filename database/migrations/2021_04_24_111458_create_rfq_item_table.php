<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_items', function (Blueprint $table) {
            $table->id();
            $table->string('rfq_id');
            $table->string('item_description', 50)->nullable();
            $table->string('s_no', 20)->nullable();
            $table->string('item_no', 20)->nullable();
            $table->string('item_expected_delivery')->format('d/M/y')->nullable();
            $table->string('qty')->nullable();
            $table->string('uom')->nullable();
            $table->foreign('rfq_id')
                    ->references('rfq_id')
                    ->on('rfqs');
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
        Schema::dropIfExists('rfq_items');
    }
}
