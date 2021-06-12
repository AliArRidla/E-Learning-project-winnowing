<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_materi');
            $table->string('nama_tugas')->nullable();
            $table->longText('content')->nullable();
            $table->string('file_tugas')->nullable();
            $table->datetime('tanggal')->nullable();
            $table->timestamps();

            $table->foreign('id_materi')->references('id')->on('materis')
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
        Schema::dropIfExists('tugas');
    }
}
