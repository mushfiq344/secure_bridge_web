@extends('admin.layouts.admin-default')


@section('content')
<div class="page-title-box">
	@include('admin.partials.admin.form.create-breadcrumbs', ['featureName'=> 'blog'])

	<form action="/admin/dashboard/blogs" method="post" enctype="multipart/form-data">
		@csrf
		@include('admin.blog.form', ['submitButtonText' => 'Save'])
	</form>

</div>
@endsection

@section('scripts')
<script src="//cdn.ckeditor.com/4.15.1/basic/ckeditor.js"></script>
<script>
	CKEDITOR.replace('content');
</script>
@endsection