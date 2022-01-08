@extends('admin.layouts.admin-default')
@section('content')
<div class="page-title-box">
  @include('admin.partials.admin.form.edit-breadcrumbs', ['featureName' => 'slider'])

  <form action="{{route('settings.update',['setting'=>$setting->id])}}" method="POST" enctype="multipart/form-data">
    @csrf

    @method('PUT')
    @include('admin.setting.form', ['submitButtonText' => 'Update'])
  </form>

  </form>
</div>
@endsection