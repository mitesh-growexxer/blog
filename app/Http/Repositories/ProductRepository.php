<?php

nameSpace App\Repositories;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Product;

class ProductRepository implements ProductRepositoryInterface
{
    
    /*
     * get Product Details
     */
    public function allProducts($request)
    {
        $query = Product::query();
        /*
        if ( $request->post('search') && $request->input('search')['value']) {
            $search = $request->input('search')['value'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('product_price', 'like', "%$search%");
            });
        }
        
        // Sorting
        if ($request->has('order')) {
            //$orderColumn = $columns[$request->input('order')[0]['column']];
            //$orderDirection = $request->input('order')[0]['dir'];
            //$query->orderBy($orderColumn, $orderDirection);
        } else {
            $query->orderBy('id', 'desc');
        }
        
        if($request->has('category_id')){
            $categoryId = (int)$request->post('category_id');
            if($categoryId > 0 ){
                $query->where('category_id' , $categoryId);
            }
        }
        
        //product data filter by name
        if($request->has('search_by')){
            $searchBy = trim($request->post('search_by'));
            if( !empty($searchBy) ){
                $query->where(function ($q) use ($searchBy) {
                    $q->orWhere('name', 'like', "%{$searchBy}%")
                    ->orWhere('description', 'like', "%{$searchBy}%");
                });
            }
        }
        
        //product data filter by type
        if($request->has('search_type')){
            $searchType = trim($request->post('search_type'));
            if( !empty($searchType) ){
                $query->where('type' , $searchType);
            }
        }
        
        //product data filter by start date
        if($request->has('search_start_date')){
            $searchStartDate = dbDate($request->post('search_start_date'));
            if( !empty($searchStartDate) ){
                $query->whereDate('created_at' , '>=' ,  $searchStartDate);
            }
        }
        
        //product data filter by end date
        if($request->has('search_end_date')){
            $searchEndDate = dbDate($request->post('search_end_date'));
            if( !empty($searchEndDate) ){
                $query->whereDate('created_at' , '<=' ,  $searchEndDate);
            }
        }
        */
        
        
        // Pagination
        $length = $request->input('length', 10);
        $currentPage = 1;
        /*
        if( $request->expectsJson() ){
            $currentPage = (int)$request->post('page_no');
        } else {
            $start = $request->input('start');
            $currentPage = ( $start / $length >= 1 ?  ( $start / $length + 1 ) : 1 );
        }
        */
        
        return $query->paginate($length , ['*'],'page', $currentPage  );
    }

    /*
     * Store Product
     */
    public function storeProduct($data)
    {
        return \App\Product::create($data);    
    }
    
    /*
     * Find Product By Id
     */
    public function findProduct($id)
    {
        return Product::findOrFail($id);
    }
    
    /*
     * Update Product
     */
    public function updateProduct($data, $id)
    {
        $product = Product::find($id);
        $product->update($data);
        return $product;
    }
    
    /*
     * Delete Product
     */
    public function deleteProduct($id)
    {
        
        $product = Product::findOrFail($id);
        $product->delete();
    }
}

