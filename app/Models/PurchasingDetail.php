<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasingDetail extends Model
{
    use HasFactory;
    protected $table = 'purchasing_detail';

    public function PurchasingMaster(){
        return $this->belongsTo(PurchasingMaster::class, 'id', 'purchasing_id');
    }
}
