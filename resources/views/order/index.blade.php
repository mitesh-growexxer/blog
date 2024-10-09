@extends('app.layout')
@section('title', $pageTitle)
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
				{{ readMessage() }}
				<div class="card">
                    <div class="card-header">
                        <h4>Orders
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-stiped table-bordered" id="order-table" summary="Order List">
                            <thead>
                                <tr>
                                    <?php /* ?>
                                    <th>{{ trans('message.sr-no') }}</th>
                                    <?php  */ ?>
                                    <th>{{ trans('messages.name') }}</th>
                                    <th>Order Date</th>
                                    <th>Order Amount</th>
                                    <th>Product Names</th>
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
    var module_url = "{{ config('app.url') . '/order' }}"
    console.log("module_url" , module_url );
    $(document).ready(function(){
    	var table_id = 'order-table';
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
                { data: 'order_date', name: 'order_date' },
                { data: 'order_amount', name: 'order_amount' },
                { data: 'product_names', name: 'product_names' }
            ]
        });
    });
    </script>

@endsection