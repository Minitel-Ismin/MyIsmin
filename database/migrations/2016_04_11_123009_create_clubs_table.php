<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('clubs', function (Blueprint $table) {
    		$table->increments('id');
    		$table->timestamps();
    		$table->string('lien');
    		$table->string('name',60);
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
        //
    }
}
