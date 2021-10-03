@extends('org_admin.layouts.org-admin-layout')
@section('head')
<link href="{{asset('frontend/drag-drop-image-uploader/dist/image-uploader.min.css')}}" rel="stylesheet">

@endsection
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
</script>
<script src="{{asset('frontend/drag-drop-image-uploader/dist/image-uploader.min.js')}}"></script>
@if(isset($opportunity->icon_image))
<script>
let preloaded_icon_image = [{
        id: 1,
        src: '{{url($uploadPath.$opportunity->icon_image)}}'
    },

    // more images here
];
</script>
@else
<script>
let preloaded_icon_image = [];
</script>
@endif
<script>
$('#icon_image').imageUploader({
    imagesInputName: 'icon_image',
    preloaded: preloaded_icon_image,

    preloadedInputName: 'preloaded_icon_image',

    extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg'],
    mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
    maxSize: 5000000,
    maxFiles: 1,
    label: 'Drag & drop opportunity icon image here'

});
</script>

@if(isset($opportunity->cover_image))
<script>
let preloaded_cover_image = [{
        id: 1,
        src: '{{url($uploadPath.$opportunity->cover_image)}}'
    },

    // more images here
];
</script>
@else
<script>
let preloaded_cover_image = [];
</script>
@endif
<script>
$('#cover_image').imageUploader({
    imagesInputName: 'cover_image',
    preloaded: preloaded_cover_image,

    preloadedInputName: 'preloaded_cover_image',

    extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg'],
    mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
    maxSize: 5000000,
    maxFiles: 1,
    label: 'Drag & drop opportunity cover image here'

});
</script>

@endsection