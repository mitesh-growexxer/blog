<?php

namespace App\DTOs;

class ProductDTO
{
    public $category_id;
    public $name;
    public $description;
    public $purchase_date;
    public $product_price;
    public $type;
    public $industry;
    public $product_image;
    
    public function __construct($request)
    {
        $this->category_id = $request->input('category_id');
        $this->name =$request->input('name');
        $this->description = $request->input('description');
        $this->purchase_date = dbDate($request->input('purchase_date'));
        $this->product_price = $request->input('product_price');
        $this->type = $request->input('type');
        $this->industry = (!empty($request->input('industry')) ? implode("," , $request->input('industry')) : null );
        $this->product_image = null;
    }
}