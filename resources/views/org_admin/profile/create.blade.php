@extends('org_admin.layouts.org-admin-layout')
@section('head')
<link href="{{asset('frontend/drag-drop-image-uploader/dist/image-uploader.min.css')}}" rel="stylesheet">

@endsection

@section('content')
<div class="section blog-section">
    <div class="container">
        @include('org_admin.partials.form.create-breadcrumbs', ['featureName'=> 'profile'])

        <form action="/org-admin/profiles" method="post" enctype="multipart/form-data">
            @csrf
            @include('org_admin.profile.form', ['submitButtonText' => 'Save'])
        </form>
    </div>
</div>
@endsection

@section('scripts')

<script src="{{asset('frontend/drag-drop-image-uploader/dist/image-uploader.min.js')}}"></script>
<script>
$('#photo').imageUploader({
    imagesInputName: 'photo',
    preloaded: [],

    preloadedInputName: 'preloaded_photo',

    extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg'],
    mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
    maxSize: 5000000,
    maxFiles: 1,
    label: 'Drag & drop your photo here'

});
</script>
@endsection