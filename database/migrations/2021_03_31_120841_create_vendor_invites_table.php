<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_invites', function (Blueprint $table) {
            $table->id();
            $table->string('person_name', 50);
            $table->string('vendor_regis_no', 20);
            $table->string('reference', 30);
            $table->string('email', 80);
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
        Schema::dropIfExists('vendor_invites');
    }
}
