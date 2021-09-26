@extends('org_admin.layouts.org-admin-layout')

@include('org_admin.partials.table.header')

@section('content')
<div class="page-title-box">
    @include('org_admin.partials.table.breadcrumbs', ['featureName' => 'opportunity'])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>

                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($oppotunities as $blog)
                            <tr>
                                <td>{{ $blog->id }}</td>
                                <td>{{ $blog->title }}</td>



                                <td>
                                    <!-- Edit -->
                                    <a href="/org-admin/opportunities/{{$blog->id}}/edit">
                                        <button type="submit" class="btn btn-default float-left"><i
                                                class="ti-pencil"></i></button>
                                    </a>

                                    <!-- delete -->
                                    <form action="{{ route('org-admin.opportunities.destroy', $blog->id)}}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-default float-left"
                                            style="margin-left: 10px;">
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

@include('org_admin.partials.table.scripts')