<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('update_arrive', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_service')->constrained('service')->onDelete('cascade');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('waktu_perjalanan')->nullable();
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
        Schema::dropIfExists('update_arrive');
    }
};
