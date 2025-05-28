<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    protected $guarded = [];
    use HasFactory;

    public function item(){
        return $this->belongsTo(Item::class);
    }
}
