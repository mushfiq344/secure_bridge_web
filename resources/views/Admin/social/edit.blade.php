@extends('admin.layouts.admin-default')
@section('content')
<div class="page-title-box">
  @include('admin.partials.admin.form.edit-breadcrumbs', ['featureName' => 'slider'])

  <form action="{{route('social-links.update',['social_link'=>$link->id])}}" method="POST" enctype="multipart/form-data">
    @csrf

    @method('PUT')
    @include('admin.social.form', ['submitButtonText' => 'Update'])
  </form>

  </form>
</div>
@endsection
