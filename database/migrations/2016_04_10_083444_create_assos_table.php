<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateAssosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
    	Schema::create('assos', function (Blueprint $table) {
    		$table->increments('id');
    		$table->string('name',60);
    		$table->timestamps();
    		$table->string('lien');
    		$table->integer('user_id')->index();
    		$table->integer('article_id')->index();
//     		$table->integer('')
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('assos');
    }
}
