@extends('admin.layouts.admin-default')
@section('content')
<div class="page-title-box">
  @include('admin.partials.admin.form.edit-breadcrumbs', ['featureName' => 'blog'])
  <form action="{{route('blogs.update',['blog'=>$blog->id])}}" method="POST" enctype="multipart/form-data">
    @csrf

    @method('PUT')
    @include('admin.blog.form', ['submitButtonText' => 'Update'])
  </form>
</div>
@endsection
@section('scripts')
<script src="//cdn.ckeditor.com/4.15.1/basic/ckeditor.js"></script>
<script>
  CKEDITOR.replace('content');
</script>
@endsection