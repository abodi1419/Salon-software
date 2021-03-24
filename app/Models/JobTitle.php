<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model
{
    use HasFactory;
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
        'show_reports'
    ];

    public function employees(){
        return $this->hasMany(Employee::class,'job_title','id');
    }
}
