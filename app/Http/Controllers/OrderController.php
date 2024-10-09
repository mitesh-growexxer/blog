<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
    public $folderName, $moduleName, $redirectUrl;
    public function __construct()
    {
        $this->folderName = 'order';
        $this->moduleName = "Orders";
        $this->redirectUrl = config('app.url') . 'order' ;
    }
    
    /*
     * Product Listing
     */
    public function index()
    {
        
        try{
            $data = [];
            $data['pageTitle'] = $this->moduleName;
            return view($this->folderName  . '.index' , $data );
        }catch(\Exception $e){
            var_dump($e->getMessage());die;
        }
    }
    
    /*
     * Filter Product Request
     */
    public function filter(Request $request)
    {
       
        //get product data
        $orders = Order::with(['orderUser','products'])->get();
        
        //product count
        $totalRecords = count($orders );
        
        $data = [];
        
        //loop for datatable
        if (!empty($orders)) {
            foreach ($orders as $order) {
                $allProductNames = null;
                if (isset($order->products)){
                    $allProductNames = implode(", " ,  array_column(json_decode(json_encode($order->products),true),'name') );
                }
                $recordId = $order->id;
                $rowData = [];
                $rowData['name'] = isset($order->orderUser->name) ? $order->orderUser->name : null;
                $rowData['order_date'] = clientDisplayDate( $order->order_date );
                $rowData['order_amount'] = $order->order_amount;
                $rowData['product_names'] = $allProductNames;
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
