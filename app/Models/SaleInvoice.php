<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoice extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','customer','sub_total','total','notes','state','counter','discount'];
    public function saleServices()
    {
        return $this->hasMany(SaleService::class,'sale_invoice_id','id');
    }

    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class,'sale_invoice_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
