<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailMapelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_mapels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_mapel');
            $table->unsignedBigInteger('id_guru');
            $table->unsignedBigInteger('id_kelas');
            $table->timestamps();

            $table->foreign('id_mapel')->references('id')->on('mapels')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_guru')->references('id')->on('gurus')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_kelas')->references('id')->on('kelas')
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
        Schema::dropIfExists('detail_mapels');
    }
}
