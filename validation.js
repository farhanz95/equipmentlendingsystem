$(function(){

	$.validator.setDefaults({
		errorClass: 'help-block',
		highlight: function(element) {
			$(element)
				.closest('div.form-group')
				.addClass('has-error');
		},
		unhighlight: function(element) {
			$(element)
				.closest('div.form-group')
				.removeClass('has-error');
		},
		errorPlacement: function(error, element) {
			if (element.prop('type') === 'checkbox') {
				error.insertAfter(element.parent());
			} else{
				error.insertAfter(element);
			}
		}
	});

	$.validator.addMethod('strongPassword', function(value,element){
		return this.optional(element)
		|| value.length >= 6
		&& /\d/.test(value)
		&& /[a-z]/i.test(value);
	}, 'Your password must be at least 6 characters long and contain at least one number and one character ')

	$.validator.addMethod( "phonesUK", function( phone_number, element ) {
	phone_number = phone_number.replace( /\(|\)|\s+|-/g, "" );
	return this.optional( element ) || phone_number.length > 9 &&
		phone_number.match( /^(?:(?:(?:00\s?|\+)6\s?|0)(?:1\d{8,9}|[23]\d{9}|7(?:[1345789]\d{8}|624\d{6})))$/ );
	}, "Please specify a valid uk phone number" );

	$("#loginForm").validate({
		rules: {
			email: {
				required: true,
				email: true,
			},
			passwordLogin: {
				required: true
			},
		},
		messages: {
			email: {
				required: 'Please enter an email address.',
				email: 'Please enter a <em>valid</em> email address'
			},
		},

		submitHandler: function(form) {
			form.submit();
		}
	});


	$("#registerForm").validate({
		rules: {
			fullname: {
				required: true,
				maxlength: 64,
			},
			email: {
				required: true,
				email: true,
				maxlength: 64,
			},
			password: {
				required: true,
				strongPassword: true
			},
			password2: {
				required: true,
				equalTo: "#password"
			},
			"checkAgreement[]": {
                required: true
			},
		},
		messages: {
			email: {
				required: 'Please enter an email address.',
				email: 'Invalid Email Address'
			},
			password2: {
				equalTo: "Error : Your Retype Password Is Not Same As Password"
			},
			"checkAgreement[]" : {
				required: '',
			}
		},

		submitHandler: function(form) {
			form.submit();
		}
	});

})