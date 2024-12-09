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
        Schema::create('tool_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_service')->constrained('service')->onDelete('cascade');
            $table->string('alat');
            $table->integer('jumlah')->default(1);
            $table->enum('jenis', ['Penggantian', 'Perbaikan'])->default('Penggantian');
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
        Schema::dropIfExists('tool_service');
    }
};
