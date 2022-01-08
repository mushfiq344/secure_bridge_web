@extends('admin.layouts.admin-default')


@section('content')
<div class="page-title-box">
	@include('admin.partials.admin.form.create-breadcrumbs', ['featureName'=> 'social-links'])

	<form action="/admin/dashboard/social-links" method="post" enctype="multipart/form-data">
		@csrf
		@include('admin.social.form', ['submitButtonText' => 'Save'])
	</form>

</div>
@endsection

@section('scripts')

@endsection