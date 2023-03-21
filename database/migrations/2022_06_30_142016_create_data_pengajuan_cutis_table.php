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
        Schema::create('data_pengajuan_cuti', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('kode_cuti');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('keterangan')->nullable();
            $table->string('file')->nullable();
            $table->string('status')->default(0);
            $table->string('komentar')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_pengajuan_cuti');
    }
};
