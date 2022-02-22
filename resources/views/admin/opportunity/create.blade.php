@extends('admin.layouts.admin-default')
@section('header')
<link href="{{asset('frontend/drag-drop-image-uploader/dist/image-uploader.min.css')}}" rel="stylesheet">

@endsection


@section('content')
<div class="page-title-box">
	@include('admin.partials.admin.form.create-breadcrumbs', ['featureName'=> 'opportunity'])

	<form action="/admin/opportunities" method="post" enctype="multipart/form-data">
		@csrf
		@include('admin.opportunity.form', ['submitButtonText' => 'Save'])
	</form>

</div>
@endsection

@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdn.ckeditor.com/4.15.1/basic/ckeditor.js"></script>
<script src="{{asset('frontend/drag-drop-image-uploader/dist/image-uploader.min.js')}}"></script>
<script>
	// In your Javascript (external .js resource or <script> tag)
	$(document).ready(function() {
		$('.js-example-basic-single').select2({
			minimumInputLength: 3,
			ajax: {
				url: "{{ route('admin.search-users')}}",
				method: "POST",
				
				processResults: function(data) {


					var users = $.map(data.users, function(obj) {
					
						return {
							"id": obj["id"],
							"text": obj["name"]
						};

					});
					
					// Transforms the top-level key of the response object from 'items' to 'results'
					return {
						results: users
					};
				}
			}
		});
	});
</script>

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
