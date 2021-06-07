<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'SSN','name','job_title','salary','phone','commission','salary_date','dob','doh'
    ];

    public function jobTitle(){
        return $this->belongsTo(JobTitle::class,'job_title','id');
    }
    public function user(){
        return $this->hasOne(User::class);
    }
    public function saleServices(){
        return $this->hasMany(SaleService::class);
    }
}
