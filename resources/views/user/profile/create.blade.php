@extends('user.layouts.user-layout')
@section('head')
<link href="{{asset('frontend/drag-drop-image-uploader/dist/image-uploader.min.css')}}" rel="stylesheet">

@endsection

@section('content')
<div class="section blog-section">
    <div class="container">
        @include('user.partials.form.create-breadcrumbs', ['featureName'=> 'profile'])

        <form action="/user/profiles" method="post" enctype="multipart/form-data">
            @csrf
            @include('user.profile.form', ['submitButtonText' => 'Save'])
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