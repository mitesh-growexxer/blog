<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Http\Exceptions\HttpResponseException;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' =>  [ 'required' , 'string', 'max:180' ],
            'email' =>  [ 'required' , 'string', 'max:120' ],
            'mobile' =>  [ 'required' , 'string', 'max:15' ],
            'city_id' => [ 'required' , 'exists:cities,id' ],
            'date_of_birth' => ['required' , 'date_format:'.config('constants.CLIENT_SIDE_RECEIVE_FORMAT') ],
            'gender' => ['required', "in:".config('constants.MALE').",".config('constants.FEMALE') ],
            'profile_pic' => [ 'mimes:jpeg,png,jpg' ]
        ];
    }
    
    protected function failedValidation(ValidatorContract $validator)
    {
        throw new HttpResponseException(response()->json( [ 'status' => false , 'message' => $validator->errors()->toArray() ]  , 422));
    }
    
    public function messages()
    {
        return [
            'name.required' => trans('messages.required-enter-field-validation' , [ 'fieldName' => trans('messages.name') ] ),
            'name.max' => trans('messages.max-length-field-validation' , [ 'length' => 180 ] ),
            'email.required' => trans('messages.required-enter-field-validation' , [ 'fieldName' => trans('messages.email') ] ),
            'email.max' => trans('messages.max-length-field-validation' , [ 'length' => 120 ] ),
            'mobile.required' => trans('messages.required-enter-field-validation' , [ 'fieldName' => trans('messages.mobile') ] ),
            'mobile.max' => trans('messages.max-length-field-validation' , [ 'length' => 15 ] ),
            'city_id.required' => trans('messages.required-select-field-validation' , [ 'fieldName' => trans('messages.city') ] ),
            'city_id.exists' => trans('messages.value-is-not-exists'),
            'date_of_birth.required' => trans('messages.required-select-field-validation' , [ 'fieldName' => trans('messages.date-of-birth') ] ),
            'date_of_birth.date_format' => trans('messages.invalid-format-selected'),
            'gender.required' => trans('messages.required-select-field-validation' , [ 'fieldName' => trans('messages.gender') ] ),
            'gender.in' => trans('messages.invalid-value-selected'),
            'profile_pic.mimes' => trans('messages.invalid-file-upload' , [ 'fileTypes' => implode(", " , [ 'JPG' , 'JPEG' , 'PNG' ]  )  ])
        ];
    }
}
