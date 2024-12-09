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
        Schema::create('schedule_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_service')->constrained('service')->onDelete('cascade');
            $table->foreignId('id_teknisi')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('waktu');
            $table->text('keterangan')->nullable();
            $table->string('estimasi_biaya')->nullable();
            $table->string('estimasi_pengerjaan')->nullable();
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
        Schema::dropIfExists('schedule_service');
    }
};
