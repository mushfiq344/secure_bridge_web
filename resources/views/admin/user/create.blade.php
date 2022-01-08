@extends('admin.layouts.admin-default')


@section('content')
<div class="page-title-box">
	@include('admin.partials.admin.form.create-breadcrumbs', ['featureName'=> 'user'])

	<form action="/admin/dashboard/users" method="post" enctype="multipart/form-data">
		@csrf
		@include('admin.user.form', ['submitButtonText' => 'Save'])
	</form>

</div>
@endsection

@section('scripts')
<script>
	$("#generate-password-btn").click(function(event) {
		event.preventDefault();
		// remove if password field already exists
		if ($('#password').length) {
			$('#password').remove();
		};
		// creating new password field
		$('<input/>').attr({
			type: 'text',
			id: 'password',
			name: 'password',
			class: 'form-control mb-2',
			required: 'required',
			value: password_generator(15, 1, 1, 1),
		}).appendTo('#generated-password-div');
	});

	function password_generator(length, useLetters, useNumbers, useSymbols) {
		const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		const numbers = '0123456789';
		const symbols = '!#$%&\()*+,-./:;<=>?@^[\\]^_`{|}~';

		let password = '';

		let validChars = '';

		// all if conditions can be used to custom password
		if (useLetters) {
			validChars += letters;
		}

		if (useNumbers) {
			validChars += numbers;
		}

		if (useSymbols) {
			validChars += symbols;
		}

		let generatedPassword = '';

		for (let i = 0; i < length; i++) {
			const index = Math.floor(Math.random() * validChars.length);
			generatedPassword += validChars[index];
		}

		password = generatedPassword;
		return password;
	}
</script>
@endsection