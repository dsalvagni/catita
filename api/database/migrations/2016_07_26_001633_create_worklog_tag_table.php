<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorklogTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worklog_tag', function (Blueprint $table) {
            $table->integer('worklog_id')->unsigned();
            $table->integer('tag_id')->unsigned();
            $table->foreign('worklog_id')->references('id')->on('worklogs')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('worklog_tag');
    }
}
