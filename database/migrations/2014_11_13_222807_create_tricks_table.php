<?php

use Illuminate\Database\Migrations\Migration;

class CreateTricksTable extends Migration
{
    public function up()
    {
        Schema::create('tricks', function ($table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->boolean('spam')->default(0);
            $table->string('title', 140);
            $table->string('slug', '50')->unique();
            $table->text('content');
            $table->integer('vote_cache')->unsigned()->default(0);
            $table->integer('view_cache')->unsigned()->default(0);
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('tricks', function ($table) {
            $table->dropForeign('tricks_user_id_foreign');
        });

        Schema::drop('tricks');
    }
}
