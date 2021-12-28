<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoeLevel800geosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_courses')->create('foe_level800geos', function (Blueprint $table) {
            $table->id();
            $table->string('course_code')->unique();
            $table->string('course_title');
            $table->string('credit_value');
            $table->string('course_master');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_courses')->dropIfExists('foe_level800geos');
    }
}