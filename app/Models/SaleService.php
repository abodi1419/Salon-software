<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleService extends Model
{
    use HasFactory;
    protected $fillable = ['sale_invoice_id','price','service_id','quantity','employee_id','after_discount','state'];

    public function service(){
        return $this->hasOne(Service::class,'id','service_id');
    }

    public function saleServices()
    {
        return $this->belongsTo(SaleInvoice::class,'id','sale_invoice_id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
