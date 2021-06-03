<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_det_mapel');
            $table->date('hari_absen');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->enum('jangka_waktu', ['6', '12']);
            $table->timestamps();

            $table->foreign('id_det_mapel')->references('id')->on('detail_mapels')
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
        Schema::dropIfExists('presensis');
    }
}
