<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoalEssaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soal_essays', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ulangan');
            $table->longText('soal');            
            $table->string('jawaban_guru');
            $table->string('jawaban_siswa')->nullable();
            $table->integer('poin')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('soal_essays');
    }
}
