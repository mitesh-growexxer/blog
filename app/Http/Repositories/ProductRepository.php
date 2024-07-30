<?php

nameSpace App\Repositories;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Product;

class ProductRepository implements ProductRepositoryInterface
{
    /*
     * Store Product
     */
    public function storeProduct($data)
    {
        return \App\Product::create($data);    
    }
}

