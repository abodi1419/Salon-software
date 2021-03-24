<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_titles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->tinyInteger('create_sale_invoices')->default(0);
            $table->tinyInteger('view_sale_invoices')->default(0);
            $table->tinyInteger('edit_sale_invoices')->default(0);
            $table->tinyInteger('delete_sale_invoices')->default(0);
            $table->tinyInteger('create_purchase_invoices')->default(0);
            $table->tinyInteger('view_purchase_invoices')->default(0);
            $table->tinyInteger('edit_purchase_invoices')->default(0);
            $table->tinyInteger('delete_purchase_invoices')->default(0);
            $table->tinyInteger('show_reports')->default(0);
            $table->tinyInteger('use_system')->default(0);
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
        Schema::dropIfExists('job_titles');
    }
}
