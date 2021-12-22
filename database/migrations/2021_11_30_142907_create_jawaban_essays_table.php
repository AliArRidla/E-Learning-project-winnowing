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
            $table->unsignedBigInteger('id_ulangan');
            $table->unsignedBigInteger('id_soal')->nullable();  ;
            $table->unsignedBigInteger('user_id')->nullable();  ;
            $table->longText('jawaban_siswa');                        
            $table->timestamps();
            
            $table->foreign('id_ulangan')->references('id')->on('ulangans')
            ->onUpdate('cascade')->onDelete('cascade');
            
            // $table->foreign('id_soal')->references('id_soal')->on('soal_essay')
            // ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    // 3 id ulanagn id sol id user
    

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
