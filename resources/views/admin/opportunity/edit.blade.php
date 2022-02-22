@extends('admin.layouts.admin-default')
@section('header')
<link href="{{asset('frontend/drag-drop-image-uploader/dist/image-uploader.min.css')}}" rel="stylesheet">

@endsection
@section('content')
<div class="page-title-box">
  @include('admin.partials.admin.form.edit-breadcrumbs', ['featureName' => 'opportunity'])

  {!! Form::model($opportunity, ['url' => '/admin/opportunities/'.$opportunity->id, 'method'=>'PATCH', 'files'=>true]) !!}
  @include('admin.opportunity.form', ['submitButtonText' => 'Update'])
  {!! Form::close() !!}
</div>
@endsection
@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdn.ckeditor.com/4.15.1/basic/ckeditor.js"></script>
<script>
CKEDITOR.replace('description');
</script>
<script src="{{asset('frontend/drag-drop-image-uploader/dist/image-uploader.min.js')}}"></script>
<script>
	// In your Javascript (external .js resource or <script> tag)
	$(document).ready(function() {
		$('.js-example-basic-single').select2({
      minimumInputLength: 1,
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
    
    var $newOption = $("<option selected='selected'></option>").val("{{$opportunity->created_by}}").text("{{\App\Models\User::getUserName($opportunity->created_by)}}")
 
    $(".js-example-basic-single").append($newOption).trigger('change');
	});
</script>
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
