@extends('app.layout')
@section('title', $pageTitle)
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
				{{ readMessage() }}
				<div class="card">
                    <div class="card-header">
                        <h4>{{ trans('messages.products') }}
                            <a href="{{ config('constants.PRODUCT_URL') . '/create'}}" class="btn btn-primary float-end">{{ trans('messages.add-module' , [ 'moduleName' => trans('messages.product') ]); }}</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-stiped table-bordered" id="product-table" summary="Product List">
                            <thead>
                                <tr>
                                    <?php /* ?>
                                    <th>{{ trans('message.sr-no') }}</th>
                                    <?php  */ ?>
                                    <th>{{ trans('messages.name') }}</th>
                                    <th>{{ trans('messages.purchase-date') }}</th>
                                    <th>{{ trans('messages.price') }}</th>
                                    <th>{{ trans('messages.type') }}</th>
                                    <th>{{ trans('messages.industry') }}</th>
                                    <th>{{ trans('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
					</div>
                </div>
            </div>
        </div>
    </div>
    <script>
    var module_url = "{{ config('constants.PRODUCT_URL') }}"
    
    $(document).ready(function(){
    	var table_id = 'product-table';
    	$('#' + table_id ).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:  module_url + '/filter',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'purchase_date', name: 'purchase_date' },
                { data: 'price', name: 'price' },
                { data: 'type', name: 'type' },
                { data: 'industry', name: 'industry' },
                { data: 'actions', name: 'actions' },
            ]
        });
    });
    
    function deleteRecord(thisitem){
    	var record_id = $.trim($(thisitem).attr('data-record-id'));
    	var record_module = $.trim($(thisitem).attr('data-module-name'));
    	
    	if( record_id != "" && record_id != null ){
    		var confirm_title = "{{ trans('messages.delete-record') }}";
    		var confirm_msg = "{{ trans('messages.common-confirm-msg' , [ 'action' => trans('messages.delete') ] )  }}";
    		var delete_url = "{{ config('app.url') }}" + '/' + record_module + '/' + record_id;
    		console.log("delete_url" , delete_url );
    		alertify.alert(confirm_title ,  confirm_msg , function(){ 
    				//form.submit();
    				$.ajax({
                        url: '{{ config('constants.PRODUCT_URL') }}/' + record_id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        dataType : 'json',
                        beforeSend : function(){
                        	showLoader();
                        },
                        success: function(response) {
                        	console.log("response" , response );
                        	hideLoader();
                            if (response.status) {
                                 location.reload();
                            } else {
                                alertify.error(response.message);
                            }
                        },
                        error: function() {
                            alert('An error occurred');
                        }
				 });
			});
    	}
    	
    }		
    </script>

@endsection