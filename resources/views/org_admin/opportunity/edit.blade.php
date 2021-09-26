@extends('org_admin.layouts.org-admin-layout')
@section('content')
<div class="page-title-box">
    @include('org_admin.partials.form.edit-breadcrumbs', ['featureName' => 'opportunity'])
    <form action="{{route('org-admin.opportunities.update',['opportunity'=>$opportunity->id])}}" method="POST"
        enctype="multipart/form-data">
        @csrf

        @method('PUT')
        @include('org_admin.opportunity.form', ['submitButtonText' => 'Update'])
    </form>
</div>
@endsection
@section('scripts')
<script src="//cdn.ckeditor.com/4.15.1/basic/ckeditor.js"></script>
<script>
CKEDITOR.replace('description');
CKEDITOR.replace('reward');
</script>
@endsection