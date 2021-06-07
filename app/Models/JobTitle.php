<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model
{
    use HasFactory;
    public $timestamps =false;
    protected $fillable = [
        'name',
        'use_system',
        'create_sale_invoices',
        'view_sale_invoices',
        'edit_sale_invoices',
        'delete_sale_invoices',
        'create_purchase_invoices',
        'view_purchase_invoices',
        'edit_purchase_invoices',
        'delete_purchase_invoices',
        'create_product',
        'edit_product',
        'view_product',
        'delete_product',
        'create_service',
        'edit_service',
        'view_service',
        'delete_service',
        'create_employee',
        'edit_employee',
        'view_employee',
        'delete_employee',
        'show_reports'
    ];

    public function employees(){
        return $this->hasMany(Employee::class,'job_title','id');
    }
}
