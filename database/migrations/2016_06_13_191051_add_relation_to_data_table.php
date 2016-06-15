<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationToDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('data', function (Blueprint $table) {
        $table->integer('users_id')->unsigned()->change();
        $table->foreign('users_id')->references('id')->on('data')->onUpdate('cascade')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('data', function (Blueprint $table) {
        $table->dropForeign('data_users_id_foreign');
      });
      Schema::table('data', function(Blueprint $table){
        $table->dropIndex('data_users_id_foreign');
      });
      Schema::table('data', function(Blueprint $table){
        $table->integer('users_id')->change();
      });
    }
}
