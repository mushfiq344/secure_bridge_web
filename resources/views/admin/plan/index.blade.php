@extends('admin.layouts.admin-default')

@include('admin.partials.admin.table.header')

@section('content')
<div class="page-title-box">
	@include('admin.partials.admin.table.breadcrumbs', ['featureName' => 'plan'])

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
						<thead>
							<tr>
								<th>Id</th>
								<th>Title</th>
							
								<th>Description</th>
								<th>Amount</th>
								<th>Duration</th>
								<th>Type</th>
								<th>Mode</th>
								<th>Action</th>

							</tr>
						</thead>
						<tbody>
							@foreach($plans as $plan)
							<tr>
								<td>{{ $plan->id }}</td>
								<td>{{ $plan->title }}</td>
								
								<td>{{ $plan->description }}</td>
								<td>{{$plan->amount}}</td>
								<td>{{$plan->duration}} Days</td>
								<td>{{\App\Models\Plan::$planTypesNames[$plan->type]}}</td>
								<td>{{\App\Models\Plan::$planModesNames[$plan->mode]}}</td>
								<td>
									<!-- Edit -->
									<a href="/admin/plans/{{$plan->id}}/edit">
										<button type="submit" class="btn btn-default float-left"><i class="ti-pencil"></i></button>
									</a> 

									<!-- delete -->
									<!-- <form action="{{ route('admin.plans.destroy', $plan->id)}}" method="POST">
										@method('DELETE')
										@csrf
										<button type="submit" class="btn btn-default float-left" style="margin-left: 10px;">
											<i class="ti-trash"></i>
										</button>
									</form> -->
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