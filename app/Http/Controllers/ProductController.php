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
     * Product Listing
     */
    public function index()
    {
        
        try{
            $data = [];
            $data['pageTitle'] = $this->moduleName;
            $data['typeDetails'] = productTypeList();
            $data['industryDetails'] = productIndustryList();
            $data['categoryDetails'] = Category::all();
            return view($this->folderName  . '.index' , $data );
        }catch(\Exception $e){
            var_dump($e->getMessage());die;
        }
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
            var_dump($e->getMessage());die;
            setFlashMessage("danger",  trans('messages.error-add' ,  [ 'moduleName' => $this->moduleName ]  ) );
        }
        
        return redirect()->to($this->redirectUrl);
        
    }
    
    /*
     * Edit Product Form
     */
    public function edit($id)
    {
        
        try{
            
            $productInfo = $this->productService->find($id);
            $data['pageTitle'] = trans('messages.update-module' , [ 'moduleName' => $this->moduleName ]);
            $data['typeDetails'] = productTypeList();
            $data['industryDetails'] = productIndustryList();
            $data['categoryDetails'] = Category::all();
            $data['recordInfo'] = $productInfo;
            return view($this->folderName  . '.create' , $data );
        }catch(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $ex){
            var_dump($ex->getMessage());die;
        }
    }
    
    /*
     * Update Product Request
     */
    
    public function update(ProductRequest $request , $id )
    {
        $productData = new ProductDTO($request);
        
        try{
            $this->productService->update((array)$productData , $id);
            setFlashMessage("success",  trans('messages.success-update' ,  [ 'moduleName' => $this->moduleName ]  ) );
        }catch(\Exception $e){
            var_dump($e->getMessage());die;
            setFlashMessage("danger",  trans('messages.error-update' ,  [ 'moduleName' => $this->moduleName ]  ) );
        }
        
        return redirect()->to($this->redirectUrl);
    }
    
    /*
     * Filter Product Request
     */
    public function filter(Request $request)
    {
       
        $products = $this->productService->all($request);
       
        $totalRecords = $products->total();
        
        $data = [];
        
        if (!empty($products)) {
            foreach ($products as $product) {
                $recordId = $product->id;
                $rowData = [];
                $rowData['name'] = $product->name;
                $rowData['purchase_date'] = clientDisplayDate( $product->purchase_date );
                $rowData['price'] = $product->product_price;
                $rowData['type'] = $product->type;
                $rowData['industry'] = (!empty($product->industry) ? $product->industry : null );
                $rowData['actions'] = '<div>';
                $rowData['actions'] .= '<a href="'.route('product.edit' , $recordId).'" class="btn btn-sm btn-info" title="'.trans('messages.edit-record').'">'.trans('messages.edit-record').'</a>';
                $rowData['actions'] .= '<button type="button" onclick="deleteRecord(this);" data-module-name="product" data-record-id="'.$recordId.'" class="btn btn-sm btn-danger ms-2" title="'.trans('messages.delete-record').'" >'.trans('messages.delete-record').'</a>';
                $rowData['actions'] .= '</div>';
                $data[] = $rowData;
            }
        }
        
        $response = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalRecords),
            "recordsFiltered" => intval($totalRecords),
            "data" => $data
        ];
        
        return response()->json($response);
    }
}
