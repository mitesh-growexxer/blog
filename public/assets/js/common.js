
function imagePreview(thisitem) {
     var input = event.target;
     var image = document.getElementById('preview');
     
     if (thisitem.files && thisitem.files[0]) {
        var reader = new FileReader();
        var uploadFileType = thisitem.files[0].type;
        var allowedFileTypes = [ 'image/jpeg' , 'image/jpg' , 'image/png' ];
        if( $.inArray( uploadFileType , allowedFileTypes ) == -1 ){
        	alertifyMessage("danger" , "invalid fiile selected");
        	$(thisitem).val("");
        	$(thisitem).parents('.file-div').find('.file-preview-src').attr('src' , ""  );
            $(thisitem).parents('.file-div').find('.file-preview-div').hide();
        	return false;
        }
        
        reader.onload = function(e) {
        	$(thisitem).parents('.file-div').find('.file-preview-src').attr('src' , e.target.result  );
            $(thisitem).parents('.file-div').find('.file-preview-div').show();
        }
        reader.readAsDataURL(thisitem.files[0]);
    } else {
    	alertifyMessage("danger" , "invalid fiile selected");
    	$(thisitem).val("");
    	$(thisitem).parents('.file-div').find('.file-preview-src').attr('src' , ""  );
        $(thisitem).parents('.file-div').find('.file-preview-div').hide();
    	return false;
    }
}

function mobileNoFormat(thisitem){
	var inputValue = $.trim($(thisitem).val());
	inputValue = inputValue.replace(/[^+\s0-9]/g, '');
	$(thisitem).val(inputValue);
}

function onlyDecimalValue(thisitem){
	var inputValue = $.trim($(thisitem).val());
	let validValue = inputValue.match(/^\d*\.?\d*$/);

    if (validValue) {
        $(thisitem).val(validValue[0]);
    } else {
        $(thisitem).val("");
    }
}

function alertifyMessage(type , message ){
	switch(type){
		case 'success':
			alertify.success(message);
			break;
		case 'danger':
			alertify.error(message);
			break;
		default:
			alertify.notify(message);
		
	}
}
$.validator.addMethod("email_regex", function(value, element) {
        return this.optional( element ) || /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,6})+$/.test( value );
}, "Please Enter Valid Email Address");
        
$.validator.addMethod("mobile_regex", function(value, element) {
    return this.optional(element) || /^\d{10}$/.test(value) && /^[6789]/.test(value);
}, "Please Enter Valid Mobile Number");

$.validator.addMethod("noSpace", function(value, element) {
  return ( $.trim(value).length != 0 );
}, "No spaces allowed");

function showLoader(){
	$.blockUI();
}

function hideLoader(){
	$.unblockUI();
}

