<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiUlangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_ulangans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_ulangan');
            $table->string('nilai');
            $table->string('benar');
            $table->string('salah');
            $table->timestamps();

            $table->foreign('id_siswa')->references('id')->on('siswas')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_ulangan')->references('id')->on('ulangans')
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
        Schema::dropIfExists('nilai_ulangans');
    }
}
