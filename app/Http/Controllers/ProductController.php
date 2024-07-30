<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;
use App\DTOs\ProductDTO;
use App\Category;

class ProductController extends Controller
{
    private $productService;
    public $folderName, $moduleName, $redirectUrl;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->folderName = 'product';
        $this->moduleName = trans('messages.product');
        $this->redirectUrl = config('constants.PRODUCT_URL');
    }
    /*
     * Add Product Form
     */
    
    public function create()
    {
        $data = [];
        $data['pageTitle'] = trans('messages.add-module' , [ 'moduleName' => $this->moduleName ]);
        $data['typeDetails'] = productTypeList();
        $data['industryDetails'] = productIndustryList();
        $data['categoryDetails'] = Category::all();
        return view($this->folderName  . '.create' , $data );
    }
    
    /*
     * Add Product Request
     */
    public function store(ProductRequest $request)
    {
        //get data
        
        $productData = new ProductDTO($request);
        
        try{
            $this->productService->create((array)$productData);
            setFlashMessage("success",  trans('messages.success-add' ,  [ 'moduleName' => $this->moduleName ]  ) );
        }catch(\Exception $e){
            setFlashMessage("danger",  trans('messages.error-add' ,  [ 'moduleName' => $this->moduleName ]  ) );
        }
        
        return redirect()->to($this->redirectUrl);
        
    }
}
