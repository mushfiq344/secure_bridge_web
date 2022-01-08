@extends('admin.layouts.admin-default')

@include('admin.partials.admin.table.header')

@section('content')
<div class="page-title-box">
	@include('admin.partials.admin.table.breadcrumbs', ['featureName' => 'user'])

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
						<thead>
							<tr>
								<th>Id</th>
								<th>Name</th>
								<th>Type</th>
								<th>Email</th>
								<th>Status</th>
								<!-- <th>Action</th> -->

							</tr>
						</thead>
						<tbody>
							@foreach($users as $user)
							<tr>
								<td>{{ $user->id }}</td>
								<td>{{ $user->name }}</td>
								<td>{{ $userTypeNames[$user->user_type] }}</td>
								<td>{{ $user->email }}</td>
								<td>
									<select class="form-control user-status" user-id="{{$user->id}}">

										<option value="0" {{$user->is_active?'':'selected'}}>Inactive</option>
										<option value="1" {{$user->is_active?'selected':''}}>Active</option>
									</select>
								</td>
								<!-- <td>-->
									<!-- Edit -->
									<!-- <a href="/admin/dashboard/users/{{$user->id}}/edit">
										<button type="submit" class="btn btn-default float-left"><i class="ti-pencil"></i></button>
									</a> -->

									<!-- delete -->
									<!-- <form action="{{ route('admin.users.destroy', $user->id)}}" method="POST">
										@method('DELETE')
										@csrf
										<button type="submit" class="btn btn-default float-left" style="margin-left: 10px;">
											<i class="ti-trash"></i>
										</button>
									</form> -->
								<!-- </td> -->
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