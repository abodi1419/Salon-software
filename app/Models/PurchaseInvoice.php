<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','vendor','sub_total','total','notes','state'];
    public function purchases()
    {
        return $this->hasMany(Purchase::class,'purchase_invoice_id',"id");
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
