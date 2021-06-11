<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ulangan');
            $table->longText('soal');
            $table->longText('pilihan_a');
            $table->longText('pilihan_b');
            $table->longText('pilihan_c');
            $table->longText('pilihan_d')->nullable();
            $table->longText('pilihan_e')->nullable();
            $table->string('kunci_jawaban');
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
        Schema::dropIfExists('soals');
    }
}
