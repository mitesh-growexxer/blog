<?php
namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    private $productRepository;
    
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    
    /*
     * Get Product Data
     */
    public function all($request)
    {
        return $this->productRepository->allProducts($request);
    }
    
    /*
     * Add Product Data
     */
    public function create($data)
    {
        return $this->productRepository->storeProduct($data);
    }
    
    /*
     * Get Product by Id
     */
    public function find($id)
    {
        return $this->productRepository->findProduct($id);
    }
    
    /*
     * Update Product Data
     */
    public function update($data, $id)
    {
        return $this->productRepository->updateProduct($data, $id);
    }
    
    /*
     * Delete Product
     */
    public function delete($id)
    {
        return $this->productRepository->deleteProduct($id);
    }
}

