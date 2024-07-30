<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ trans('messages.register') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/common.css') }}" >
    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
  </head>
  <body>
    <div class="row justify-content-center mt-5">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">{{ trans('messages.register') }}</h1>
                </div>
                <div class="card-body">
                    @include('display-form-errors')
                    @if(Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <form action="{{ route('register') }}" method="POST" id="register-form" >
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ trans('messages.name') }}</label>
                            <input type="text" name="name" class="form-control" placeholder="{{ trans('messages.name') }}" value="{{ old('name') }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ trans('messages.email-address') }}</label>
                            <input type="email" name="email" class="form-control" placeholder="{{ trans('messages.email-address') }}" value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ trans('messages.password') }}</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="{{ trans('messages.password') }}" autocomplete="new-password">
                        </div>
                        <div class="mb-3">
                            <div class="d-grid">
                                <button class="btn btn-primary" title="{{ trans('messages.submit') }}">{{ trans('messages.submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.blockUI.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/common.js') }}"></script>
    <script>
    $(document).ready(function(){
        $("#register-form").validate({
    		rules : {
    			name : {
    				required : true
    			},
    			email : {
    				required : true,
    				email_regex : true
    			},
    			password : {
    				required : true,
    			},
    		},
    		messages : {
    			name : {
    				required : "{{ trans('messages.required-enter-field-validation' , [ 'fieldName' => trans('messages.name') ] ) }}"
    			},
    			email : {
    				required : "{{ trans('messages.required-enter-field-validation' , [ 'fieldName' => trans('messages.email-address') ] ) }}"
    			},
    			password : {
    				required : "{{ trans('messages.required-enter-field-validation' , [ 'fieldName' => trans('messages.password') ] ) }}"
    			},
    		},
    		submitHandler : function(form){
    			showLoader();
    			form.submit();
    		}
    	});
	})
    </script>
  </body>
</html>