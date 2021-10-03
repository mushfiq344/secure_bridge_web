@extends('org_admin.layouts.org-admin-layout')
@section('head')
<link href="{{asset('frontend/drag-drop-image-uploader/dist/image-uploader.min.css')}}" rel="stylesheet">

@endsection

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
<script src="{{asset('frontend/drag-drop-image-uploader/dist/image-uploader.min.js')}}"></script>
<script>
CKEDITOR.replace('description');
</script>
<script>
$('#icon_image').imageUploader({
    imagesInputName: 'icon_image',
    preloaded: [],

    preloadedInputName: 'preloaded_icon_image',

    extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg'],
    mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
    maxSize: 5000000,
    maxFiles: 1,
    label: 'Drag & drop opportunity icon image here'

});
$('#cover_image').imageUploader({
    imagesInputName: 'cover_image',
    preloaded: [],

    preloadedInputName: 'preloaded_cover_image',

    extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg'],
    mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
    maxSize: 5000000,
    maxFiles: 1,
    label: 'Drag & drop opportunity cover image here'

});
</script>
@endsection