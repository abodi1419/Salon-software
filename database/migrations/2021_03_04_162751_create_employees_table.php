<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('SSN')->unique();
            $table->unsignedBigInteger('job_title');
            $table->foreign('job_title')->references('id')->on('job_titles');
            $table->decimal("salary",7,2,true);
            $table->string('phone',10);
            $table->unsignedInteger('commission');
            $table->date('dob');
            $table->date('doh');
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
        Schema::dropIfExists('employees');
    }
}
