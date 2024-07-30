<?php
namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    private $repository;
    
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    
    public function all($request)
    {
        return $this->productRepository->allProducts($request);
    }
    
    public function create($data)
    {
        return $this->productRepository->storeProduct($data);
    }
    
    public function find($id)
    {
        return $this->productRepository->findProduct($id);
    }
    
    public function update($data, $id)
    {
        return $this->productRepository->updateProduct($data, $id);
    }
    
    public function delete($id)
    {
        return $this->productRepository->deleteProduct($id);
    }
}

