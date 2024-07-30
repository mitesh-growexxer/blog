<?php

namespace App\Repositories\Interfaces;

Interface ProductRepositoryInterface
{
    public function allProducts($request);
    
    public function storeProduct($data);
    
}
