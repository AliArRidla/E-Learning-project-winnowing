<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanEssaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban_essays', function (Blueprint $table) {
            $table->id();
            // id_ulangan
            $table->unsignedBigInteger('id_ulangan');
            // id_soal_essays
            $table->unsignedBigInteger('id_soal_essays');
            // id role
            // jika 1 2 dan 3 ???
            $table->unsignedBigInteger('user_id');            
            // jawaban essay siswa 
            $table->string('jawaban_siswa')->nullable();                                                 
            // poin
            $table->integer('poin')->nullable();            
            $table->timestamps();

            // relasi 
            // tabel ulangan 
            $table->foreign('id_ulangan')->references('id')->on('ulangans')
            ->onUpdate('cascade')->onDelete('cascade');

            // tabel soal essays
            $table->foreign('id_soal_essays')->references('id')->on('soal_essays')
            ->onUpdate('cascade')->onDelete('cascade');

            // tabel role user
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('jawaban_essays');
    }
}
