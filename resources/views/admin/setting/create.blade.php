@extends('admin.layouts.admin-default')


@section('content')
<div class="page-title-box">
	@include('admin.partials.admin.form.create-breadcrumbs', ['featureName'=> 'setting'])

	<form action="/admin/dashboard/settings" method="post" enctype="multipart/form-data">
		@csrf
		@include('admin.setting.form', ['submitButtonText' => 'Save'])
	</form>

</div>
@endsection

@section('scripts')

@endsection