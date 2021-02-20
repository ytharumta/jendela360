<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasingMaster extends Model
{
    use HasFactory;
    protected $table = 'purchasing_master';
    
    public function PurchasingDetail(){
        return $this->hasMany(PurchasingDetail::class,'purchasing_id','id');
    }
}
