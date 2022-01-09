<div class="row align-items-center">
	<!-- Breadcrumbs-->
	<div class="col-sm-6">
		<h4 class="page-title">{{ ucfirst(\Str::plural($featureName)) }}</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
			<li class="breadcrumb-item active">{{ ucfirst(\Str::plural($featureName)) }}
			</li>
		</ol>
	</div>
	<div class="col-sm-6">
		<div class="float-right d-none d-md-block">
			<div class="dropdown">
				<a href="/admin/{{ \Str::plural($featureName) }}/create" class="btn btn-primary  arrow-none waves-effect waves-light" aria-haspopup="true" aria-expanded="false">
					<i class="mdi mdi-plus mr-2"></i> New {{ ucfirst($featureName) }}
				</a>
			</div>
		</div>
	</div>
</div>