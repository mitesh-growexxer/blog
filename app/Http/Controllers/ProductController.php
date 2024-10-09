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
            
            //product type list
            $data['typeDetails'] = productTypeList();
            
            //product industry info
            $data['industryDetails'] = productIndustryList();
            
            //category details for dropdown
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
        
        //product type list
        $data['typeDetails'] = productTypeList();
        
        //product industry info
        $data['industryDetails'] = productIndustryList();
        
        //category details for dropdown
        $data['categoryDetails'] = Category::all();
        
        //render add product view
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
            //add data
            $this->productService->create((array)$productData);
            
            //set message
            setFlashMessage("success",  trans('messages.success-add' ,  [ 'moduleName' => $this->moduleName ]  ) );
        }catch(\Exception $e){
            var_dump($e->getMessage());die;
            setFlashMessage("danger",  trans('messages.error-add' ,  [ 'moduleName' => $this->moduleName ]  ) );
        }
        
        //redirect to listing page
        return redirect()->to($this->redirectUrl);
        
    }
    
    /*
     * Edit Product Form
     */
    public function edit($id)
    {
        
        try{
            //get product info based on ud
            $productInfo = $this->productService->find($id);
            $data['pageTitle'] = trans('messages.update-module' , [ 'moduleName' => $this->moduleName ]);
            
            //product type list
            $data['typeDetails'] = productTypeList();
            
            //product industry info
            $data['industryDetails'] = productIndustryList();
            
            //category details for dropdown
            $data['categoryDetails'] = Category::all();
            
            $data['recordInfo'] = $productInfo;
            
            //render edit product view
            return view($this->folderName  . '.create' , $data );
        }catch(\Exception $e){
            var_dump($e->getMessage());die;
        }
    }
    
    /*
     * Update Product Request
     */
    
    public function update(ProductRequest $request , $id )
    {
        $productData = new ProductDTO($request);
        
        try{
            
            //update product
            $this->productService->update((array)$productData , $id);
            
            //success message
            setFlashMessage("success",  trans('messages.success-update' ,  [ 'moduleName' => $this->moduleName ]  ) );
        }catch(\Exception $e){
            var_dump($e->getMessage());die;
            setFlashMessage("danger",  trans('messages.error-update' ,  [ 'moduleName' => $this->moduleName ]  ) );
        }
        
        //redirect to listing page
        return redirect()->to($this->redirectUrl);
    }
    
    /*
     * Delete Product Request
     */
    public function destroy($id)
    {
        try{
            //delete product by id
            $this->productService->delete($id);
            
            //set success message
            setFlashMessage("success",  trans('messages.success-delete' ,  [ 'moduleName' => $this->moduleName ]  ) );
            return response()->json(['status' => true ] , 200 );
        }catch(\Exception $e){
            setFlashMessage("danger",  trans('messages.error-delete' ,  [ 'moduleName' => $this->moduleName ]  ) );
            return response()->json(['status' => false ,  'message' =>  trans('messages.error-delete' ,  [ 'moduleName' => $this->moduleName ] )  ] , 500 );
        }
        
    }
    
    /*
     * Filter Product Request
     */
    public function filter(Request $request)
    {
       
        //get product data
        $products = $this->productService->all($request);
       
        //product count
        $totalRecords = $products->total();
        
        $data = [];
        
        //loop for datatable
        if (!empty($products)) {
            foreach ($products as $product) {
                $recordId = $product->id;
                $rowData = [];
                $rowData['name'] = $product->name;
                $rowData['purchase_date'] = clientDisplayDate( $product->purchase_date );
                $rowData['product_price'] = $product->product_price;
                $rowData['type'] = $product->type;
                $rowData['industry'] = (!empty($product->industry) ? $product->industry : null );
                $rowData['commentCount'] = (!empty($product->commentInfo) ? $product->commentInfo->count() : null );
                $rowData['orderedCount'] = isset($product->total_quantity) ? $product->total_quantity : 0;
                $rowData['actions'] = '<div>';
                $rowData['actions'] .= '<a href="'.route('product.edit' , $recordId).'" class="btn btn-sm btn-info" title="'.trans('messages.edit-record').'">'.trans('messages.edit-record').'</a>';
                $rowData['actions'] .= '<button type="button" onclick="deleteRecord(this);" data-module-name="product" data-record-id="'.$recordId.'" class="btn btn-sm btn-danger ms-2" title="'.trans('messages.delete-record').'" >'.trans('messages.delete-record').'</a>';
                $rowData['actions'] .= '</div>';
                $data[] = $rowData;
            }
        }
        
        //response info
        $response = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalRecords),
            "recordsFiltered" => intval($totalRecords),
            "data" => $data
        ];
        
        return response()->json($response);
    }
}
