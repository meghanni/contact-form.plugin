jQuery(document).ready(function($) {

	$('#contact-form').validate({ 
	
		errorElement: 'span',
		errorClass: 'help-inline',
		
		highlight: function(element) {
		$(element).closest('.control-group').removeClass('success').addClass('error');
		},
		success: function(element) {
		element
		.closest('.control-group').removeClass('error').addClass('success');
		} 
	
	
	});

});