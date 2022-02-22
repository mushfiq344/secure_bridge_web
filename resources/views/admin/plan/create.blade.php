@extends('admin.layouts.admin-default')


@section('content')
<div class="page-title-box">
	@include('admin.partials.admin.form.create-breadcrumbs', ['featureName'=> 'plan'])

	<form action="/admin/plans" method="post" enctype="multipart/form-data">
		@csrf
		@include('admin.plan.form', ['submitButtonText' => 'Save'])
	</form>

</div>
@endsection

@section('scripts')

@endsection