<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug');
            $table->text('summary')->nullable();
            $table->text('content');
            $table->string('folder')->nullable();
            $table->string('image')->nullable();
            $table->bigInteger('cate_id')->unsigned();
            $table->foreign('cate_id')
                ->references('id')
                ->on('cate_news')
                ->onDelete('cascade');
            $table->bigInteger('author_id')->nullable();
            $table->bigInteger('question_id')->nullable();
            $table->timestamps();
        });
        Schema::create('tagnews', function (Blueprint $table) {
            $table->string('name');
            $table->bigInteger('news_id')->unsigned();
            $table->foreign('news_id')
                ->references('id')
                ->on('news')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
