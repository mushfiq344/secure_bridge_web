@extends('admin.layouts.admin-default')

@include('admin.partials.admin.table.header')

@section('content')
<div class="page-title-box">
	@include('admin.partials.admin.table.breadcrumbs', ['featureName' => 'mail'])

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
						<thead>
							<tr>
								<th>Id</th>
								<th>Title</th>
								<th>Body</th>
								<th>ACtion</th>
							</tr>
						</thead>
						<tbody>
							@foreach($mails as $mail)
							<tr>
								<td>{{ $mail->id }}</td>
								<td>{{ $mail->title }}</td>
								<td>{{ $mail->body }}</td>
								<td>
									<!-- Edit -->
									<!-- <a href="/admin/sliders/{{$mail->id}}/edit">
										<button type="submit" class="btn btn-default float-left"><i class="ti-pencil"></i></button>
									</a> -->

									<!-- delete -->
									<form action="{{ route('mails.destroy', $mail->id)}}" method="POST">
										@method('DELETE')
										@csrf
										<button type="submit" class="btn btn-default float-left" style="margin-left: 10px;">
											<i class="ti-trash"></i>
										</button>
									</form>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@include('admin.partials.admin.table.scripts')

@section('scripts')

@endsection