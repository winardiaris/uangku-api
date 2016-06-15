<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      //
      Schema::create('data',function($table){
        $table->increments('id');
        $table->integer('users_id');
        $table->date('date');
        $table->string('bill',100);
        $table->enum('type', ['in', 'out']);
        $table->double('value');
        $table->longText('desc');
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
      Schema::drop('data');
    }
}
