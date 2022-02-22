@extends('admin.layouts.admin-default')

@include('admin.partials.admin.table.header')

@section('content')
<div class="page-title-box">
	@include('admin.partials.admin.table.breadcrumbs', ['featureName' => 'opportunity'])

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
						<thead>
							<tr>
								<th>Id</th>
								<th>Title</th>
								<th>Opportunity Date</th>
								<th>Duration</th>
								<th>Reward</th>
								<th>Status</th>
								<th>Featured</th>
								<th>Action</th>

							</tr>
						</thead>
						<tbody>
							@foreach($opportunities as $opportunity)
							<tr>
								<td>{{ $opportunity->id }}</td>
								<td>{{ $opportunity->title }}</td>
								<td>{{$opportunity->opportunity_date}}</td>
								<td>{{$opportunity->duration}} Days</td>
								<td>{{$opportunity->reward}}</td>
								<td>{{\App\Models\Opportunity::$opportunityStatusNames[$opportunity->status]}}</td>
								<td><select class="form-control feature-status" opportunity-id="{{$opportunity->id}}">

										<option value="0" {{$opportunity->is_featured?'':'selected'}}>Not Featured</option>
										<option value="1" {{$opportunity->is_featured?'selected':''}}>Featured</option>
									</select></td>
								<td>
									<!-- Edit -->
									<a href="/admin/opportunities/{{$opportunity->id}}/edit">
										<button type="submit" class="btn btn-default float-left"><i class="ti-pencil"></i></button>
									</a>

									<!-- delete -->
									<!-- <form action="{{ route('admin.plans.destroy', $opportunity->id)}}" method="POST">
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