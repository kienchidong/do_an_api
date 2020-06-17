<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('list_question');
            $table->integer('status')->default(1);
            $table->integer('level');
            $table->timestamps();
        });

        Schema::create('test_user', function (Blueprint $table){
            $table->bigInteger('user_id');
            $table->bigInteger('test_id');
            $table->integer('level');
            $table->integer('point');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
        Schema::dropIfExists('test_user');
    }
}
