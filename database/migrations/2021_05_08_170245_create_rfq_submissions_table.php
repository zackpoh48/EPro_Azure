<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('rfq_id');
            $table->string('tender_title')->nullable();
            $table->date('date_of_rfq')->format('d/m/Y')->nullable();
            $table->string('priority', 10)->nullable();
            $table->date('date_of_expiry')->format('d/m/Y')->nullable();
            $table->string('quotation_no')->nullable();
            $table->date('delivery_date')->format('d/m/Y')->nullable();
            $table->date('offer_validity')->format('d/m/Y')->nullable();
            $table->string('quality')->nullable();
            $table->string('pay_terms')->nullable();
            $table->decimal('advance_paid')->nullable();
            $table->string('pay_mode')->nullable();
            $table->string('currency')->nullable();
            $table->binary('buyer_remarks')->nullable();
            $table->binary('supplier_remarks')->nullable();
            $table->float('total')->nullable();
            $table->float('document_discount')->nullable();
            $table->string('terms_condition')->nullable();
            $table->date('quotation_date')->format('d/m/Y')->nullable();
            $table->string('vendor_number')->nullable();
            $table->string('delivery_code')->nullable();
            $table->string('delivery_location')->nullable();
            $table->date('expected_delivery')->format('d/m/Y')->nullable();
            $table->boolean('status');
            $table->string('nav_status')->default('created');
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->longText('fault_code')->nullable();
            $table->longText('soap_data')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('rfq_submissions');
    }
}
