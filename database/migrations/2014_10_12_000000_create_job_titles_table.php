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

            $table->tinyInteger('create_product')->default(0);
            $table->tinyInteger('edit_product')->default(0);
            $table->tinyInteger('view_product')->default(0);
            $table->tinyInteger('delete_product')->default(0);

            $table->tinyInteger('create_service')->default(0);
            $table->tinyInteger('edit_service')->default(0);
            $table->tinyInteger('view_service')->default(0);
            $table->tinyInteger('delete_service')->default(0);

            $table->tinyInteger('create_employee')->default(0);
            $table->tinyInteger('edit_employee')->default(0);
            $table->tinyInteger('view_employee')->default(0);
            $table->tinyInteger('delete_employee')->default(0);

            $table->tinyInteger('show_reports')->default(0);
            $table->tinyInteger('use_system')->default(0);

        });

        \Illuminate\Support\Facades\DB::table('job_titles')->insert(
            array(
                'name'=>'مديرة النظام',
                'create_sale_invoices'=>1,
                'view_sale_invoices'=>1,
                'edit_sale_invoices'=>1,
                'delete_sale_invoices'=>1,
                'create_purchase_invoices'=>1,
                'view_purchase_invoices'=>1,
                'edit_purchase_invoices'=>1,
                'delete_purchase_invoices'=>1,
                'create_product'=>1,
                'edit_product'=>1,
                'view_product'=>1,
                'delete_product'=>1,
                'create_service'=>1,
                'edit_service'=>1,
                'view_service'=>1,
                'delete_service'=>1,
                'create_employee'=>1,
                'edit_employee'=>1,
                'view_employee'=>1,
                'delete_employee'=>1,
                'show_reports'=>1,
                'use_system'=>1,
            )
        );
        \Illuminate\Support\Facades\DB::table('job_titles')->insert(
            array(
                'name'=>'أخصائية',
                'use_system'=>'0'
            )
        );
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
