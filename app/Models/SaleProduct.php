<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleProduct extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['sale_invoice_id','price','product_id','quantity'];

    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function saleInvoice()
    {
        return $this->belongsTo(SaleInvoice::class,'sale_invoice_id','id');
    }

}
