<?php

namespace App\Models;

use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    
    public function details(){
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
