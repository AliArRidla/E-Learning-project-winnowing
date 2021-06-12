<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiTugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_tugas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tugas');
            $table->unsignedBigInteger('id_siswa');
            $table->string('file_tugas')->nullable();
            $table->longText('content')->nullable();
            $table->string('nilai')->nullable();
            $table->datetime('waktu_pengumpulan')->nullable();
            $table->timestamps();

            $table->foreign('id_tugas')->references('id')->on('tugas')
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
        Schema::dropIfExists('nilai_tugas');
    }
}
