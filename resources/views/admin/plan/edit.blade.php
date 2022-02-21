@extends('admin.layouts.admin-default')
@section('content')
<div class="page-title-box">
  @include('admin.partials.admin.form.edit-breadcrumbs', ['featureName' => 'plan'])

  {!! Form::model($plan, ['url' => '/admin/plans/'.$plan->id, 'method'=>'PATCH', 'files'=>true]) !!}
  @include('admin.plan.form', ['submitButtonText' => 'Update'])
  {!! Form::close() !!}
</div>
@endsection