@extends('user.layouts.user-layout')
@section('head')
<link href="{{asset('frontend/drag-drop-image-uploader/dist/image-uploader.min.css')}}" rel="stylesheet">

@endsection
@section('content')
<div class="section blog-section">
    <div class="container">
        @include('user.partials.form.edit-breadcrumbs', ['featureName' => 'profile'])
        <form action="{{route('user.profiles.update',['profile'=>$profile->id])}}" method="POST"
            enctype="multipart/form-data">
            @csrf

            @method('PUT')
            @include('user.profile.form', ['submitButtonText' => 'Update'])
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script src="//cdn.ckeditor.com/4.15.1/basic/ckeditor.js"></script>

<script src="{{asset('frontend/drag-drop-image-uploader/dist/image-uploader.min.js')}}"></script>
@if(isset($profile->photo))
<script>
let preloaded_photo = [{
        id: 1,
        src: '{{url($uploadPath.$profile->photo)}}'
    },

    // more images here
];
</script>
@else
<script>
let preloaded_photo = [];
</script>
@endif
<script>
$('#photo').imageUploader({
    imagesInputName: 'photo',
    preloaded: preloaded_photo,

    preloadedInputName: 'preloaded_photo',

    extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg'],
    mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
    maxSize: 5000000,
    maxFiles: 1,
    label: 'Drag & drop photo here'

});
</script>



@endsection