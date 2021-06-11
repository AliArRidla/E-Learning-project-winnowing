<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUlangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ulangans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_det_mapel');
            $table->string('judul_ulangan');
            $table->date('tgl_ulangan');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->enum('is_poin', ['1', '0']);
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
        Schema::dropIfExists('ulangans');
    }
}
