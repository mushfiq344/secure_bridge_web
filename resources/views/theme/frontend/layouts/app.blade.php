<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Secure Bridges</title>
    <link rel="icon" type="image/png" href="{{asset('frontend/theme/assets/img/favicon.jpeg')}}" />


    <!--Core CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('frontend/theme/assets/css/bulma.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/theme/assets/css/app.css')}}">
    <link id="theme-sheet" rel="stylesheet" href="{{asset('frontend/theme/assets/css/purple.css')}}">

    <!-- fcm -->
    <script src="https://www.gstatic.com/firebasejs/7.11.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.11.0/firebase-messaging.js"></script>
    <link rel="manifest" href="{{asset('manifest.json')}}">

    @yield('head')
    <style>
    .capital-text {
        text-transform: uppercase;
    }
    </style>

</head>

<body class="is-theme-core">
    <div id="preloader-div" class="pageloader"></div>
    <div class="infraloader is-active"></div>
    <div class="hero product-hero is-app-grey is-relative is-default is-bold">

        <!-- navbar -->

        @include('theme.frontend.partials.header')
        <!-- main banner -->

        @yield('main-banner')

    </div>
    @yield('content')















    <!-- Side footer -->
    @include('theme.frontend.partials.footer')
    <!-- /Side footer -->

    <!-- Back To Top Button -->
    <div id="backtotop"><a href="#"></a></div>



    <!-- Concatenated jQuery and plugins -->
    <script src="{{asset('frontend/theme/assets/js/app.js')}}"></script>

    <!-- Bulkit js -->
    <script src="{{asset('frontend/theme/assets/js/functions.js')}}"></script>
    <script src="{{asset('frontend/theme/assets/js/auth.js')}}"></script>
    <script src="{{asset('frontend/theme/assets/js/contact.js')}}"></script>
    <script src="{{asset('frontend/theme/assets/js/main.js')}}"></script>


    <!-- Landing page js -->



    <!-- firebase -->
    @guest
    @else
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
    <script>
    var firebaseConfig = {
        apiKey: "AIzaSyC1INsAB6RLhMiW5RSwhadJ4wgb4FUzxvU",
        authDomain: "simply-notify-c393c.firebaseapp.com",
        databaseURL: "https://simply-notify-c393c.firebaseio.com",
        projectId: "simply-notify-c393c",
        storageBucket: "simply-notify-c393c.appspot.com",
        messagingSenderId: "47266570047",
        appId: "1:47266570047:web:30f53a255bf6c500743d8a"
    };



    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    function generate_token() {

        messaging
            .requestPermission()
            .then(function() {
                return messaging.getToken()
            })
            .then(function(token) {
                console.log(token);



            }).catch(function(err) {
                console.log('User Chat Token Error' + err);
            });
    }
    generate_token();
    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(noteTitle, noteOptions);
    });
    </script>
    @endguest

    @yield('scripts')

    <!-- scripts -->
    <script src="{{asset('frontend/js/reg-steps-helper.js')}}"></script>

    <script src="{{asset('frontend/js/bootstrap-notify.js')}}"></script>

    @if(Session::has('success'))
    <script type="text/javascript">
    iziToast.show({
        class: 'success-toast',
        icon: 'sl sl-icon-check',
        title: 'Success,',
        message: "{{ Session::get('success') }}",
        titleColor: '#fff',
        messageColor: '#fff',
        iconColor: "#fff",
        backgroundColor: '#00b289',
        progressBarColor: '#444F60',
        position: 'topRight',
        transitionIn: 'fadeInDown',

        zindex: 99999
    });
    </script>
    @elseif(Session('status'))
    <script type="text/javascript">
    iziToast.show({
        class: 'success-toast',
        icon: 'sl sl-icon-check',
        title: 'Success,',
        message: "{{ session('status') }}",
        titleColor: '#fff',
        messageColor: '#fff',
        iconColor: "#fff",
        backgroundColor: '#00b289',
        progressBarColor: '#444F60',
        position: 'topRight',
        transitionIn: 'fadeInDown',

        zindex: 99999
    });
    </script>
    @elseif(Session::has('error'))
    <script type="text/javascript">
    iziToast.show({
        class: 'danger-toast',
        icon: 'sl sl-icon-close',
        title: 'Error,',
        message: "{{ Session::get('error') }}",
        titleColor: '#fff',
        messageColor: '#fff',
        iconColor: "#fff",
        backgroundColor: '#FF7273',
        progressBarColor: '#444F60',
        position: 'topRight',
        transitionIn: 'fadeInDown',

        zindex: 99999
    });
    </script>
    @endif

    @if (session('resent'))
    <script type="text/javascript">
    iziToast.show({
        class: 'success-toast',
        icon: 'sl sl-icon-check',
        title: 'Success,',
        message: "A fresh verification link has been sent to your email address.",
        titleColor: '#fff',
        messageColor: '#fff',
        iconColor: "#fff",
        backgroundColor: '#00b289',
        progressBarColor: '#444F60',
        position: 'topRight',
        transitionIn: 'fadeInDown',

        zindex: 99999
    });
    </script>
    @endif

    @if ($errors->any())

    @foreach ($errors->all() as $error)
    <script type="text/javascript">
    iziToast.show({
        class: 'danger-toast',
        icon: 'sl sl-icon-close',
        title: 'Error,',
        message: "{{$error}}",
        titleColor: '#fff',
        messageColor: '#fff',
        iconColor: "#fff",
        backgroundColor: '#FF7273',
        progressBarColor: '#444F60',
        position: 'topRight',
        transitionIn: 'fadeInDown',

        zindex: 99999
    });
    </script>

    @endforeach
    @endif
</body>

</html>