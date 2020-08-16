<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('news', function (Blueprint $table){
            $table->string('summary')->nullable()->change();
            $table->string('folder')->nullable()->change();
            $table->string('image')->nullable()->change();
           $table->bigInteger('author_id')->nullable();
           $table->bigInteger('question_id')->nullable();
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
