<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
  <title>Uncrowd</title>
  <meta content="Themesbrand" name="author">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ asset('images/static_images/favicon.png') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @yield('header')

  <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('admin/css/metismenu.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('admin/css/icons.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('admin/css/style.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">

  <!-- select 2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />


  <!-- custom -->
  <style type="text/css">
    .required,
    .error {
      color: red;
    }
  </style>
</head>

<body>
  <div id="wrapper">
    <div class="topbar">
      <div class="topbar-left">
        <a href="{{asset('/')}}" class="logo">
          <span>
            <!-- change here -->
            <img src="{{asset('admin/images/uncrowd_logo2.png')}}" alt="" height="50">
          </span>
          <i>
            <!-- change here -->
            <img src="{{asset('admin/images/uncrowd_logo_sm.png')}}" alt="logo" width="70" height="55" style="padding: 3px">
          </i>
        </a>
      </div>
      <nav class="navbar-custom">
        <ul class="navbar-right d-flex list-inline float-right mb-0">
          <!-- full screen -->
          <li class="dropdown notification-list d-none d-md-block">
            <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
              <i class="mdi mdi-fullscreen noti-icon"></i>
            </a>
          </li>
          <!-- user name -->
          <li class="dropdown notification-list">
            <div class="dropdown notification-list nav-pro-img">
              <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                {{Auth::user()->name}} <i class="fa fa-caret-down" aria-hidden="true"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                <a class="dropdown-item" href="/admin/dashboard">
                  <i class="mdi mdi-database-edit"></i>
                  Dashboard
                </a>
                <!-- <a class="dropdown-item d-block" href="/admin/settings">
                  <i class="mdi mdi-wallet m-r-5"></i> Settings
                </a> -->
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                  <i class="mdi mdi-power text-danger"></i> Logout
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </a>
              </div>
            </div>
          </li>
        </ul>
        <ul class="list-inline menu-left mb-0">
          <li class="float-left">
            <button class="button-menu-mobile open-left waves-effect">
              <i class="mdi mdi-menu"></i>
            </button>
          </li>
        </ul>
      </nav>
    </div>

    @include('admin.partials.admin.sidebar')

    <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          @yield('content')
        </div>
      </div>

      <script src="{{asset('admin/js/jquery.min.js')}}"></script>
      <script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>
      <script src="{{asset('admin/js/metisMenu.min.js')}}"></script>
      <script src="{{asset('admin/js/jquery.slimscroll.js')}}"></script>
      <script src="{{asset('admin/js/waves.min.js')}}"></script>
      <script src="{{asset('admin/js/app.js')}}"></script>
      <script src="{{asset('admin/js/bootstrap-notify.js')}}"></script>
      <script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
      <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>

      <!-- custom -->
      <script src="{{asset('admin/js/admin.js')}}"></script>

      @yield('scripts')

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




      @if ($errors->any())

      @foreach ($errors->all() as $error)
      <script type="text/javascript">
        $.notify({
          icon: 'pe-7s-close-circle',
          message: "{{$error}}"

        }, {
          type: 'danger',
          timer: 4000
        });
      </script>
      @endforeach
      @endif

      <script>
        var toolbarOptions = [
          ['bold', 'italic', 'underline', 'strike'], // toggled buttons
          ['blockquote', 'code-block'],

          [{
            'header': 1
          }, {
            'header': 2
          }], // custom button values
          [{
            'list': 'ordered'
          }, {
            'list': 'bullet'
          }],
          [{
            'script': 'sub'
          }, {
            'script': 'super'
          }], // superscript/subscript
          [{
            'indent': '-1'
          }, {
            'indent': '+1'
          }], // outdent/indent
          [{
            'direction': 'rtl'
          }], // text direction

          [{
            'size': ['small', false, 'large', 'huge']
          }], // custom dropdown
          [{
            'header': [1, 2, 3, 4, 5, 6, false]
          }],
          ['link', 'image', 'video', 'formula'], // add's image support
          [{
            'color': []
          }, {
            'background': []
          }], // dropdown with defaults from theme
          [{
            'font': []
          }],
          [{
            'align': []
          }],

          ['clean'] // remove formatting button
        ];
        var editorAboutus = new Quill('#editorAboutus', {
          modules: {
            toolbar: toolbarOptions
          },
          theme: 'snow'
        });
        var editorShipping = new Quill('#editorShipping', {
          modules: {
            toolbar: toolbarOptions
          },
          theme: 'snow'
        });
        var editorReturn = new Quill('#editorReturn', {
          modules: {
            toolbar: toolbarOptions
          },
          theme: 'snow'
        });
        var editorTerms = new Quill('#editorTerms', {
          modules: {
            toolbar: toolbarOptions
          },
          theme: 'snow'
        });
        var editorPrivacy = new Quill('#editorPrivacy', {
          modules: {
            toolbar: toolbarOptions
          },
          theme: 'snow'
        });

        var editorPrivacy = new Quill('#editorHowtobuy', {
          modules: {
            toolbar: toolbarOptions
          },
          theme: 'snow'
        });
      </script>
    </div>
</body>

</html>