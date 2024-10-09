<?php

namespace App\Repositories\Interfaces;

Interface ProductRepositoryInterface
{
    //get product data
    public function allProducts($request);
    
    //store product
    public function storeProduct($data);
    
    //find product by id
    public function findProduct($id);
    
    //update product
    public function updateProduct($data, $id);
    
    //delete product
    public function deleteProduct($id);
    
}
