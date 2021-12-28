<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoaLevel400hisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_courses')->create('foa_level400his', function (Blueprint $table) {
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
        Schema::connection('mysql_courses')->dropIfExists('foa_level400his');
    }
}
