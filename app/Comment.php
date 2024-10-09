<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    //
    use SoftDeletes;

    public function productInfo(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
