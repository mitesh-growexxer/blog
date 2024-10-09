@extends('app.layout')
@section('title', $pageTitle)
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ $pageTitle }}</h4>
                    </div>
                    <div class="card-body">
                        	@include('display-form-errors')
                        	@if( isset($recordInfo) && ( $recordInfo->id > 0 ) )
                        		<form action="{{ config('constants.PRODUCT_URL') . '/' . $recordInfo->id  }}" id="add-product-form" method="POST" enctype="multipart/form-data">
                        		{{ method_field('PUT') }}
                        	@else
                        		<form action="{{ config('constants.PRODUCT_URL') . '/store' }}" id="add-product-form" method="POST" enctype="multipart/form-data">
                        	@endif
                        	
                            {{ csrf_field() }}
							<div class="mb-3">
                             	<label>{{ trans('messages.category') }} <span class="text-danger">*</span></label>
                             	<select class="form-select" name="category_id">
                                	<option value="">{{ trans('messages.select') }}</option>
                                     @if(!empty($categoryDetails))
                                    	@foreach($categoryDetails as $categoryDetail)
                                    		@php 
                                    		$cityId = $categoryDetail->id;
                                    		$selected = "";
                                    		if( isset($recordInfo) && ( $recordInfo->category_id  == $categoryDetail->id ) ){
                                    			$selected = "selected='selected'";
                                    		} 
                                    		@endphp
                                    		<option value="{{ $cityId }}" {{ $selected }}>{{ $categoryDetail->name }}</option>
                                    	@endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>{{ trans('messages.name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="{{ trans('messages.name') }}" value="{{ old('name' , ( isset($recordInfo->name) ? $recordInfo->name : '' ) ) }}"/>
                            </div>
                            <div class="mb-3">
                                <label>{{ trans('messages.description') }}</label>
                                <textarea name="description" rows="3" class="form-control" placeholder="{{ trans('messages.description') }}">{{ old('description' , ( isset($recordInfo->description) ? $recordInfo->description : '' ) ) }}</textarea>
                            </div>
                            
                            <div class="mb-3" style="position: relative; z-index: 100000;" >
                                <label >{{ trans('messages.purchase-date') }} <span class="text-danger">*</span></label>
                                <input type="text" name="purchase_date" class="form-control" placeholder="{{ trans('messages.purchase-date') }}" value="{{ old('purchase_date' , ( isset($recordInfo->purchase_date) ? clientDisplayDate( $recordInfo->purchase_date ) : '' ) ) }}" />
                            </div>
                            <div class="mb-3">
                                <label>{{ trans('messages.price') }} <span class="text-danger">*</span></label>
                                <input type="text" name="product_price"  class="form-control" onkeyup="onlyDecimalValue(this);" onchange="onlyDecimalValue(this);" placeholder="{{ trans('messages.price') }}" value="{{ old('product_price' , ( isset($recordInfo->product_price) ? $recordInfo->product_price : '' ) ) }}" />
                            </div>
                             <div class="mb-3">
                             	<label>{{ trans('messages.type') }} <span class="text-danger">*</span></label>
                                @if(!empty($typeDetails))
                                	@foreach($typeDetails as $typeKey =>  $typeDetail)
                                		@php
                                		$checked = "";
                                    	if( isset($recordInfo->type) && ( $recordInfo->type  == $typeDetail ) ){
                                    		$checked = "checked";
										}
                                		@endphp
                                		<div class="form-check">
                                        	<input class="form-check-input" {{ $checked }} type="radio" name="type" value="{{ $typeKey }}" id="type_{{  $typeKey }}">
                                      		<label class="form-check-label" for="type_{{ $typeKey }}">
                                        		{{ $typeDetail }}
                                      		</label>
                                    	</div>
                                	@endforeach
                                @endif
                                <label id="type-error" class="error" for="type" style="display:none;" ></label>
                            </div>
                            <div class="mb-3">
                            	<label>{{ trans('messages.industry') }} <span class="text-danger">*</span></label>
                            	@if(!empty($industryDetails))
                            		@foreach($industryDetails as  $industryKey =>  $industryDetail)
                            			@php
                                		$checked = "";
                                    	if( isset($recordInfo->industry) &&  ( in_array( $industryDetail , explode("," , $recordInfo->industry ) ) ) ){
                                    		$checked = "checked";
										}
                                		@endphp
                            			<div class="form-check">
                                        	<input class="form-check-input" {{ $checked  }} type="checkbox" name="industry[]" value="{{ $industryKey }}" id="industry_checkbox_{{ $industryKey }}">
                                          	<label class="form-check-label" for="industry_checkbox_{{ $industryKey }}">
                                            	{{ $industryDetail }}
                                          	</label>
                                        </div>	
                            		@endforeach
                            	@endif
                            	<label id="industry[]-error" class="error" for="industry[]" style="display:none;"  ></label>
                            </div>
                            <?php /* ?>
                            <div class="mb-3 file-div">
                              <label for="formFile" class="form-label">{{ trans('messages.product-image') }}</label>
                              <input class="form-control" type="file" name="product_image" id="formFile" onchange="imagePreview(this);">
                              <div class="file-preview-div" style="display:none;">
                              	<button type="button" onclick="removeImage(this);" class="close AClass">
                                   <span>&times;</span>
                                </button>
                              	<img src="" alt="{{ trans('messages.product-image') }}" class="file-preview-src" height="200" width="200">
                              </div>
                            </div>
                            <?php */ ?>
                            
                            <div class="mb-3">
                            	@if( isset($recordInfo) && ( $recordInfo->id > 0 ) )
                            		<button type="submit" class="btn btn-primary" title="{{ trans('messages.update') }}">{{ trans('messages.update') }}</button>
                            	@else
                            		<button type="submit" class="btn btn-primary" title="{{ trans('messages.submit') }}">{{ trans('messages.submit') }}</button>
                            	@endif
                                <a href="{{ config('constants.PRODUCT_URL')  }}" class="btn btn-secondary ms-2" title="{{ trans('messages.back') }}">{{ trans('messages.back') }}</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function(){
    
    	$("[name='purchase_date']").datetimepicker({
    		format: 'DD-MM-YYYY',
            viewMode: 'days',
            showClose : true, 
            widgetPositioning: { 
                horizontal: 'left'
            }
    	});
    	$("#add-product-form").validate({
    		rules : {
    			category_id : {
    				required : true,
    				noSpace : true,
    			},
    			name : {
    				required : true,
    				noSpace : true,
    			},
    			description : {
    				required : false,
    				noSpace : false,
    			},
    			purchase_date : {
    				required : true,
    			},
    			product_price : {
    				required : true,
    				noSpace : true,
    			},
    			type : {
    				required : true
    			},
    			"industry[]" : {
    				required : true
    			},
    			product_image : {
    				required : true
    			},
    		},
    		messages : {
    			category_id : {
    				required : "{{ formValidationMessage('select' ,  trans('messages.category')) }}"
    			},
    			name : {
    				required : "{{ formValidationMessage('enter' ,  trans('messages.name'))  }}"
    			},
    			description : {
    				required : "{{ formValidationMessage('enter' ,  trans('messages.description')) }}"
    			},
    			purchase_date : {
    				required : "{{ formValidationMessage('select' ,  trans('messages.purchase-date')) }}"
    			},
    			product_price : {
    				required : "{{ formValidationMessage('enter' ,  trans('messages.price')) }}"
    			},
    			type : {
    				required : "{{ formValidationMessage('select' ,  trans('messages.type')) }}"
    			},
    			"industry[]" : {
    				required : "{{ formValidationMessage('select' ,  trans('messages.industry')) }}"
    			},
    			product_image : {
    				required : "{{ formValidationMessage('upload' ,  trans('messages.product-image')) }}"
    			},
    		},
    		submitHandler : function(form){
    			
    			var confirm_title = "{{ $pageTitle }}";
    			var confirm_msg = "{{ trans('messages.common-confirm-msg' , [ 'action' => trans('messages.add') ] )  }}";
    			
    			@if( isset($recordInfo) && ( $recordInfo->id > 0 ) )
    				confirm_title = "{{ $pageTitle }}";
    				confirm_msg = "{{ trans('messages.common-confirm-msg' , [ 'action' => trans('messages.update') ] )  }}";	
    			@endif
    			
    			alertify.confirm(confirm_title, confirm_msg, function() {
                    showLoader(); 
    				form.submit();
                },function() {
                    
                });
    		}
    	})
    })
    </script>

@endsection