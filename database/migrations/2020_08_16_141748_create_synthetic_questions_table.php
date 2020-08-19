<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyntheticQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('synthetic_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('listening');
            $table->text('reading');
            $table->integer('level');
            $table->integer('number_question')->default(0);
            $table->integer('time')->default(5);
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
        Schema::dropIfExists('synthetic_questions');
    }
}
