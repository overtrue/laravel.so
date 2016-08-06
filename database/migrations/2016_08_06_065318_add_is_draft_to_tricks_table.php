<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsDraftToTricksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tricks', function (Blueprint $table) {
            $table->boolean('is_draft')->after('slug')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tricks', function (Blueprint $table) {
            $table->dropColumn('is_draft');
        });
    }
}
