<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // DANGER: this deletes all existing data in states
        Schema::dropIfExists('states');

        Schema::create('states', function (Blueprint $table) {
            $table->bigIncrements('id');        // primary key
            $table->char('code', 2)->unique();  // e.g. 01..17
            $table->string('name', 100);
            $table->timestamp('updated_at')
                  ->nullable()
                  ->useCurrent()
                  ->useCurrentOnUpdate();
            // no created_at by request
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
