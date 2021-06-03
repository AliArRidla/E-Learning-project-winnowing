<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPresensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_presensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_presensi');
            $table->unsignedBigInteger('id_siswa');
            $table->string('keterangan')->nullable();
            $table->dateTime('waktu_absen')->nullable();
            $table->timestamps();

            $table->foreign('id_presensi')->references('id')->on('presensis')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_siswa')->references('id')->on('siswas')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_presensis');
    }
}
