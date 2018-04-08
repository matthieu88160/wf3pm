
function usernameValidatorCallback(event){
	var xhr = event.target;
	
	if (xhr.readyState !== 4) {
		return;
	}
	
	var json = JSON.parse(xhr.response);
	
	if (json.available) {
		$('#form_username').attr('aria-describedby', 'inputError2Status');
		
		var html = '<span class="glyphicon glyphicon-ok form-control-feedback usernameValidatorCallback" aria-hidden="true"></span><span id="inputSuccess2Status" class="sr-only usernameValidatorCallback">(success)</span>';
		
		$('.usernameValidatorCallback').remove();
		$('#form_username').parent().removeClass('has-success has-error has-warning has-feedback');
		$('#form_username').parent().addClass('has-success has-feedback');
		$('#form_username').after(html);
		$('#form_submit').attr('disabled', false);
	} else {
		$('#form_username').attr('aria-describedby', 'inputError2Status');
		
		var html = '<span class="glyphicon glyphicon-remove form-control-feedback usernameValidatorCallback" aria-hidden="true"></span><span id="inputError2Status" class="sr-only usernameValidatorCallback">(error)</span>';

		$('.usernameValidatorCallback').remove();
		$('#form_username').parent().removeClass('has-success has-error has-warning has-feedback');
		$('#form_username').parent().addClass('has-error has-feedback');
		$('#form_username').after(html);
		$('#form_submit').attr('disabled', true);
	}
}

function beforeValidate(validator) {
	$('#form_username').attr('aria-describedby', 'inputError2Status');
	var html = '<span class="glyphicon glyphicon-warning-sign form-control-feedback usernameValidatorCallback" aria-hidden="true"></span><span id="inputError2Status" class="sr-only usernameValidatorCallback">(warning)</span>';

	$('.usernameValidatorCallback').remove();
	$('#form_username').parent().removeClass('has-success has-error has-warning has-feedback');
	$('#form_username').parent().addClass('has-warning has-feedback');
	$('#form_username').after(html);
	$('#form_submit').attr('disabled', true);
}
