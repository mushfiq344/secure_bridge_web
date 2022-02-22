@extends('admin.layouts.admin-default')
@section('head')
<!--Chartist Chart CSS -->
<link rel="stylesheet" href="{{asset('admin/plugins/chartist/css/chartist.min.css')}}">
@endsection
@section('content')
<div class="page-title-box">
    <div class="row align-items-center">
        <!-- Breadcrumbs-->
        <div class="col-sm-6">
            <h4 class="page-title">Admin Dashboard</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Secure Bridges</a></li>
                <li class="breadcrumb-item active">Dashboard
                </li>
            </ol>
        </div>
    </div>
</div><!-- end row -->
@endsection
@section('scripts')
<!--Chartist Chart-->
<script src="{{asset('admin/plugins/chartist/js/chartist.min.js')}}"></script>
<script src="{{asset('admin/plugins/chartist/js/chartist-plugin-tooltip.min.js')}}"></script>
<!-- peity JS -->
<script src="{{asset('admin/plugins/peity-chart/jquery.peity.min.js')}}"></script>
<script src="{{asset('admin/pages/dashboard.js')}}"></script>
@endsection