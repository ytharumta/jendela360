<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesMaster extends Model
{
    use HasFactory;
    protected $table = 'sales_master';

    public function SalesDetail(){
        return $this->hasMany(PurchasingDetail::class,'sales_id','id');
    }

}
