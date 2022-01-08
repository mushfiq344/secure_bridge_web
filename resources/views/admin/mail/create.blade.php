@extends('admin.layouts.admin-default')


@section('content')
<div class="page-title-box">
	@include('admin.partials.admin.form.create-breadcrumbs', ['featureName'=> 'mail'])

	<form action="/admin/dashboard/mails" method="post" enctype="multipart/form-data">
		@csrf
		@include('admin.mail.form', ['submitButtonText' => 'Save'])
	</form>

</div>
@endsection

@section('scripts')

@endsection
