<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataToAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('class')->nullable();
            $table->string('profile_image');
            $table->enum('status' , [1 , 0]);
        });

        Schema::table('menus' , function(Blueprint $table){
            $table->string('image');
        });

        Schema::table('stores' , function(Blueprint $table){
            $table->string('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('class');
            $table->dropColumn('profile_image');
            $table->dropColumn('status');
        });

        Schema::table('menus' , function(Blueprint $table){
            $table->dropColumn('image');
        });

        Schema::table('stores' , function(Blueprint $table){
            $table->dropColumn('image');
        });
    }
}
