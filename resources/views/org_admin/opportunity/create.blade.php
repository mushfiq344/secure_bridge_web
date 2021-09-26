@extends('org_admin.layouts.org-admin-layout')


@section('content')
<div class="page-title-box">
    @include('org_admin.partials.form.create-breadcrumbs', ['featureName'=> 'opportunity'])

    <form action="/org-admin/opportunities" method="post" enctype="multipart/form-data">
        @csrf
        @include('org_admin.opportunity.form', ['submitButtonText' => 'Save'])
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