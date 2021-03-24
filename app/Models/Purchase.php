<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = ['purchase_invoice_id','price','product_id','quantity'];
    public $timestamps = false;

    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function purchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class,'purchase_invoice_id','id');
    }
}
