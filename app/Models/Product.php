<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','quantity','price','notes'];

    public function purchase(){
        return $this->belongsToMany(Purchase::class);
    }
    public function saleServices(){
        return $this->belongsToMany(SaleProduct::class);
    }

}
