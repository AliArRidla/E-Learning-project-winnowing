<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSoalEssaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('soal_essays', function($table) {
            // $table->string('similarity');
            // $table->unsignedBigInteger('user_id');            
            // tabel role user
            // $table->foreign('user_id')->references('id')->on('users')
            // ->onUpdate('cascade')->onDelete('cascade');
            
            // $table->foreign('user_id')->references('id')->on('users')
            // ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id_guru')->references('id')->on('users')
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
        Schema::table('soal_essays', function($table) {
            $table->dropColumn('similarity');
        });
    }
}
