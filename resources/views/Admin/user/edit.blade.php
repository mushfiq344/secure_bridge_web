@extends('layouts.admin-default')
@section('content')
<div class="page-title-box">
  @include('partials.admin.form.edit-breadcrumbs', ['featureName' => 'slider'])

  {!! Form::model($slider, ['url' => '/admin/sliders/'.$slider->id, 'method'=>'PATCH', 'files'=>true]) !!}
  @include('admin.slider.form', ['submitButtonText' => 'Update'])
  {!! Form::close() !!}
</div>
@endsection