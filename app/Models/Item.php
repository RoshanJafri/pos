<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    public function portion(){
        return $this->belongsTo(Portion::class, 'portion_id');
    }
}
