<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvenementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evenements', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title");
            $table->integer('lieu_id')->index();
            $table->string('description');
            $table->dateTime("start");
            $table->dateTime("end");
            $table->integer('user_id')->index();
            $table->integer('assos_id')->index();
            $table->integer('clubs_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('evenements');
    }
}
