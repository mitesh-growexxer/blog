<?php

/**
 * Convert Client Input Date into Database Date Format
 */
if(!function_exists('dbDate'))
{
    function dbDate($inputDate)
    {
        $result = null;
        if(!empty($inputDate)){
            $result = date( 'Y-m-d' , strtotime($inputDate) );
        }
        return $result;
    }
}

/**
 * Convert date value into client display format based on constants value
 */
if(!function_exists('clientDisplayDate'))
{
    function clientDisplayDate($dbDate)
    {
        $result = null;
        if(!empty($dbDate)){
            $result = date( config('constants.CLIENT_DISPLAY_DATE_FORMAT') , strtotime($dbDate) );
        }
        return $result;
    }
}

/**
 * Convert datetime value into client display datetime format based on constants value
 */
if(!function_exists('clientDisplayDateTime'))
{
    function clientDisplayDateTime($dbDate)
    {
        $result = null;
        if(!empty($dbDate)){
            $result = date( config('constants.CLIENT_DISPLAY_DATE_TIME_FORMAT') , strtotime($dbDate) );
        }
        return $result;
    }
}

/**
 * Display File Path for Api Response
 */
if(!function_exists('apiFilePath'))
{
    function apiFilePath($dbPath)
    {
        $result = null;
        if(!empty($dbPath)){
            $result = $dbPath;
        }
        return $result;
    }
}

/**
 * Gender List
 */
if(!function_exists('genderList'))
{
    function genderList()
    {
        $data = [];
        $data[config('constants.MALE')] = trans('messages.male');
        $data[config('constants.FEMALE')] = trans('messages.female');
        return $data;
    }
}

/**
* Hobby List
*/
if(!function_exists('hobbyList'))
{
    function hobbyList()
    {
        $data = [];
        $data[config('constants.CRICKET')] = trans('messages.cricket');
        $data[config('constants.CHESS')] = trans('messages.chess');
        $data[config('constants.TRAVEL')] = trans('messages.travel');
        return $data;
    }
}

/**
 * Actions Session Message
 */
if(!function_exists('setFlashMessage'))
{
    function setFlashMessage($type , $message)
    {
        $contain = '<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">';
        $contain .= $message;
        $contain .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        session()->flash('message' , $contain);
    }
}

/**
 * Hobby List
 */
if(!function_exists('readMessage'))
{
    function readMessage()
    {
        if( session()->has('message') ){
            echo session()->get('message');
        }
    }
}

/**
 * Product Type List
 */
if(!function_exists('productTypeList'))
{
    function productTypeList()
    {
        $data = [];
        $data[config('constants.PRODUCT_TYPE')] = trans('messages.product');
        $data[config('constants.SERVICE_TYPE')] = trans('messages.service');
        return $data;
    }
}

/**
 * Product Industry List
 */
if(!function_exists('productIndustryList'))
{
    function productIndustryList()
    {
        $data = [];
        $data[config('constants.PHARMA')] = trans('messages.pharma');
        $data[config('constants.BEAUTY_CARE')] = trans('messages.beauty-care');
        return $data;
    }
}

if(!function_exists('formValidationMessage'))
{
    function formValidationMessage($type , $fieldName)
    {
       $message = null; 
        switch($type){
            case 'enter':
                $message = trans('messages.required-enter-field-validation' , [ 'fieldName' => $fieldName ] );
                break;
            case 'select':
                $message = trans('messages.required-select-field-validation' , [ 'fieldName' => $fieldName ] );
                break;
            case 'upload':
                $message = trans('messages.required-upload-field-validation' , [ 'fieldName' => $fieldName ] );
                break;
            default:
                $message = trans('messages.required-enter-field-validation' , [ 'fieldName' => $fieldName ] );
                break;
        }
        return $message;
    }
}