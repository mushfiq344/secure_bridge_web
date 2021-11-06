@extends('org_admin.layouts.org-admin-layout')
@section('head')
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="section blog-section">
    <div class="container">
        @include('org_admin.partials.table.breadcrumbs', ['featureName' => 'user-opportunities',])
        <div class="columns is-vcentered">
            <div class="column is-8 is-offset-2">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>Opportunity Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userOpportunities as $userOpportunity)
                        <tr>
                            <td>{{\App\Models\User::getUserName($userOpportunity->user_id)}}</td>
                            <td>{{\App\Models\User::getUserEmail($userOpportunity->user_id)}}</td>
                            <td>{{\App\Models\Opportunity::getOpportunityTitle($userOpportunity->opportunity_id)}}</td>
                            <td>{{$userOpportunity->status}}</td>
                            <td>
                                <!-- delete -->
                                <form action="{{ route('org-admin.user-opportunities.update', $userOpportunity->id)}}"
                                        method="POST">
                                        @method('PUT')
                                        @csrf
                                        @if($userOpportunity->status=="confirmed")
                                        <button type="submit" class="btn btn-default float-left"
                                            style="margin-left: 10px;">
                                            <i class="fa fa-close"></i>
                                        </button>
                                        @else
                                        <button type="submit" class="btn btn-default float-left"
                                            style="margin-left: 10px;">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        @endif
                                </form>

                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>Opportunity Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

@endsection