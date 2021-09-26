<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <title>Secure Bridge</title>
    <meta content="Admin Dashboard" name="description">
    <meta content="Xplex" name="author">
    <link rel="shortcut icon" href="{{asset('admin/images/favicon.ico')}}">
    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/css/metismenu.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">
    <!-- custom -->
    <style type="text/css">
    .required,
    .error {
        color: red;
    }
    </style>
</head>

<body>
    <div class="home-btn d-none d-sm-block"><a href="index.html" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="wrapper-page">
        @yield('content')
    </div><!-- end wrapper-page -->
    <!-- jQuery  -->
    <script src="{{asset('admin/js/jquery.min.js')}}"></script>
    <script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('admin/js/metisMenu.min.js')}}"></script>
    <script src="{{asset('admin/js/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('admin/js/waves.min.js')}}"></script>
    <script src="{{asset('admin/js/app.js')}}"></script>
    <script src="{{asset('admin/js/bootstrap-notify.js')}}"></script>
    <script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>

    @if(Session::has('success'))
    <script type="text/javascript">
    $.notify({
        icon: 'pe-7s-check',
        message: "{{ Session::get('success') }}"
    }, {
        type: 'success',
        timer: 4000
    });
    </script>

    @elseif (session('status'))
    <script type="text/javascript">
    $.notify({
        icon: 'pe-7s-check',
        message: "{{ Session::get('status') }}"
    }, {
        type: 'success',
        timer: 4000
    });
    </script>


    @elseif(Session::has('error'))
    <script type="text/javascript">
    $.notify({
        icon: 'pe-7s-close-circle',
        message: "{{ Session::get('error') }}"

    }, {
        type: 'danger',
        timer: 4000
    });
    </script>
    @endif
</body>

</html>