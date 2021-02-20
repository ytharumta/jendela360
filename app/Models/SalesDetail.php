<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    use HasFactory;
    protected $table = 'sales_detail';

    public function SalesMaster(){
        return $this->belongsTo(SalesMaster::class, 'id', 'sales_id');
    }
}
