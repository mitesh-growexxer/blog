<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    public function orderUser()
    {
        return $this->belongsTo(USer::class, 'user_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_infos', 'order_id', 'product_id');
    }
}
