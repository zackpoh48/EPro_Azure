<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_invites', function (Blueprint $table) {
            $table->id();
            $table->string('rfq_id');
            $table->string('person_name');
            $table->string('company_name');
            $table->string('vendor_regis_no', 20);
            $table->string('reference', 30);
            $table->string('email', 80);
            $table->string('password');
            $table->integer('status');
            $table->rememberToken();
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
        Schema::dropIfExists('rfq_invites');
    }
}
