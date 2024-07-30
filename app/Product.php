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
}
