<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCOlor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("assos", function (Blueprint $table) {
            
            $table->string("color")->default("#3a87ad");
            $table->string("text_color")->default('white');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("assos", function (Blueprint $table) {
            
            $table->dropColumn("color");
            $table->dropColumn("text_color");
            
        });
    }
}
