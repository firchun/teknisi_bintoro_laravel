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
        Schema::create('finished_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_service')->constrained('service')->onDelete('cascade');
            $table->enum('jenis_kerusakan', ['Berat', 'Sedang', 'Ringan'])->default('Ringan');
            $table->text('keterangan');
            $table->string('foto_hasil');
            $table->string('waktu_penyelesaian')->nullable();
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
        Schema::dropIfExists('finished_service');
    }
};
