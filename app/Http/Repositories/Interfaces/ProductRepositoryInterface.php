<?php

namespace App\Repositories\Interfaces;

Interface ProductRepositoryInterface
{
    public function allProducts($request);
    
    public function storeProduct($data);
    
    public function findProduct($id);
    
    public function updateProduct($data, $id);
    
}
