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
        Schema::create('service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')
                ->constrained('users')
                ->onDelete('cascade');
            $table->string('alamat');
            $table->text('keterangan');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('foto')->nullable();
            $table->string('video')->nullable();
            $table->boolean('diterima')->default(0);
            $table->boolean('selesai')->default(0);
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
        Schema::dropIfExists('service');
    }
};
