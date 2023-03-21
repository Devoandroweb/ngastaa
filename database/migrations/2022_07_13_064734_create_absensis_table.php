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
        Schema::create('ms_absensi', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('menit');
            $table->tinyInteger('keterangan')->comment("1 : datang, 2 pulang");
            $table->string('kode_tunjangan')->nullable();
            $table->string('pengali')->nullable();
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
        Schema::dropIfExists('ms_absensi');
    }
};
