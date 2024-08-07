<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiImg extends Model{
    use HasFactory;

    protected $guarded = [];
    
    public function product(){
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
