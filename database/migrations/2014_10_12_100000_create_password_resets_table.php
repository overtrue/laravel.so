<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email', 50)->index();
            $table->string('token', 64)->index();
            $table->timestamp('created_at');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('password_resets');
    }
}
