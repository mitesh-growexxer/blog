<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'purchase_date',
        'product_price',
        'type',
        'industry',
        'product_image'
    ];
    /**
     * Product Category Relationship
     */
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function commentInfo()
    {
        return $this->hasMany(Comment::class, 'product_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_infos')->withPivot('qty');
    }

    public function getTotalQuantityAttribute()
    {
        return $this->orders()->sum('order_infos.qty');
    }
}
