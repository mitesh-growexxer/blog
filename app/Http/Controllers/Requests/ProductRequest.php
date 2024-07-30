<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'category_id' => [ 'required' , 'exists:categories,id' ],
            'name' =>  [ 'required' , 'string', 'max:180' ],
            'purchase_date' => ['required' , 'date_format:'.config('constants.CLIENT_SIDE_RECEIVE_FORMAT') ],
            'product_price' => [ 'required' , 'regex:/^\d+(\.\d{1,2})?$/' ],
            'type' => ['required', "in:".config('constants.PRODUCT_TYPE').",".config('constants.SERVICE_TYPE') ],
            'industry' => 'required',
            'product_main_image' => [ 'mimes:jpeg,png,jpg' ]
        ];
    }
    
    protected function failedValidation(ValidatorContract $validator)
    {
        
        // throw new HttpResponseException(response()->json( [ 'status' => false , 'message' => $validator->errors()->toArray() ]  , 422));
        $response = $this->expectsJson()
        ? response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 422)
        : redirect()->back()->withErrors($validator)->withInput();
        
        throw new ValidationException($validator, $response);
        
        
    }
    
    public function messages()
    {
        return [
            'category_id.required' => 'Category is Required',
            'category_id.exists' => 'Category Not Exists.',
            'name.required' => 'Product Name is Required.',
            'purchase_date.required' => 'Purchase Date is Required.',
            'purchase_date.date_format' => 'Invalid Format for Purchase Date.',
            'product_price.required' => 'Product Price is Required.',
            'product_price.regex' => 'Invalid Value for Product Price.',
            'type.required' => 'Product Type is Required.',
            'type.in' => 'Invalid Product Type Selected.',
            'industry.required' => 'Product Industry is Required.',
            'product_main_image.mimes' => "Only Image Files are allowed."
        ];
    }
}
