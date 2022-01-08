@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- {{--data tables--}} -->
    <link href="{{asset('admin/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet"
          type="text/css">
    <link href="{{asset('admin/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
    <!-- {{-- Responsive datatable examples --}} -->
    <link href="{{asset('admin/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet"
          type="text/css">
    <!-- {{--css for toggle --}} -->
    <link href="{{ asset('css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <style type="text/css">
        img {
            width: auto;
            height: 40px;
        }

        .table-custom{
            border-collapse: collapse; 
            border-spacing: 0; 
            width: 100%;
        }
    </style>
@endsection