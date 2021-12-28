<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('matricule')->unique();
            $table->date('date_of_birth');
            $table->string('sub_division');
            $table->string('place_of_birth');
            $table->string('phone_number');
            $table->string('gender');
            $table->string('country');
            $table->string('region');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('father_contact');
            $table->string('mother_contact');
            $table->string('parent_address');
            $table->string('faculty');
            $table->string('department');
            $table->string('image_url')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('gce_ol')->nullable();
            $table->string('gce_al')->nullable();
            $table->string('password');
            $table->datetime('registered_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
