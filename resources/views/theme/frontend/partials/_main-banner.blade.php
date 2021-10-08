<!-- Hero image -->
<div id="main-hero" class="hero-body">
    <div class="container has-text-centered">
        <div class="columns is-vcentered">
            <div class="column is-5 signup-column has-text-left">
                <h1 class="title main-title text-bold is-2">
                    FOUND, FUNDED
                </h1>
                <h2 class="subtitle is-5 no-margin-bottom body-color">

                </h2>
                <br>
                <!-- Signup form -->
                <div class="signup-block">
                    <form>
                        {{--<div class="control">
                            <input type="email" class="input" placeholder="Your email address" id="subscribe-newsletter">
                            <button type="submit" class="button btn-align primary-btn raised" id="subscribe-btn">Susbcribe</button>
                        </div>--}}
                        <a id="#signup-btn" href="{{ route('register') }}"
                            class="button button-cta btn-outlined is-bold btn-align primary-btn rounded raised">
                            Join Secure Bridges
                        </a>
                    </form>
                </div>
            </div>
            <div class="column is-6 is-offset-1">
                <!-- Hero mockup -->
                <figure class="image">
                    <img src="{{asset('frontend/theme/assets/img/graphics/compositions/hero-people-4-core.svg')}}"
                        data-base-url="assets/img/graphics/compositions/hero-people-2" data-extension=".svg" alt="">
                </figure>
            </div>
        </div>
    </div>
</div>

<!-- Clients -->
{{--<div class="hero-foot">
    <div class="container">
        <div class="tabs partner-tabs is-centered">
            <ul>
                <li><a><img class="partner-logo" src="{{asset('images/static_images/c1.png')}}" alt=""></a></li>
<li><a><img class="partner-logo" src="{{asset('images/static_images/c2.png')}}" alt=""></a></li>
<li><a><img class="partner-logo" src="{{asset('images/static_images/c3.png')}}" alt=""></a></li>
<li><a><img class="partner-logo" src="{{asset('images/static_images/c4.png')}}" alt=""></a></li>

</ul>
</div>
</div>
</div>--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="{{asset('frontend/js/bootstrap-notify.js')}}"></script>
<script>
$("#subscribe-btn").click(function(event) {
    event.preventDefault();

    var email = $("#subscribe-newsletter").val();

    var search_box = $("#subscribe-newsletter");


    if (validateEmail(email)) {
        $.ajax({
            type: 'POST',
            url: "{{ route('subscriber')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                email: email
            },

            success: (response) => {
                console.log(response);
                iziToast.show({
                    class: 'success-toast',
                    icon: 'sl sl-icon-check',
                    title: 'Success,',
                    message: response,
                    titleColor: '#fff',
                    messageColor: '#fff',
                    iconColor: "#fff",
                    backgroundColor: '#00b289',
                    progressBarColor: '#444F60',
                    position: 'topRight',
                    transitionIn: 'fadeInDown',

                    zindex: 99999
                });

                search_box.val('');
            },



            error: function(data) {
                iziToast.show({
                    class: 'danger-toast',
                    icon: 'sl sl-icon-close',
                    title: 'Error,',
                    message: 'Something is wrong, please try again!',
                    titleColor: '#fff',
                    messageColor: '#fff',
                    iconColor: "#fff",
                    backgroundColor: '#FF7273',
                    progressBarColor: '#444F60',
                    position: 'topRight',
                    transitionIn: 'fadeInDown',

                    zindex: 99999
                });
            }
        });

    } else {
        iziToast.show({
            class: 'warning-toast',
            icon: 'sl sl-icon-lock',
            title: 'Warning,',
            message: 'This is not a valid email address!',
            titleColor: '#fff',
            messageColor: '#fff',
            iconColor: "#fff",
            backgroundColor: '#eda514',
            progressBarColor: '#444F60',
            position: 'topRight',
            transitionIn: 'fadeInDown',

            zindex: 99999
        });
    }



});

function validateEmail(str) {
    return new RegExp(/([\w\.\-_]+)?\w+@[\w-_]+(\.\w+){1,}/, 'igm').test(str);
}
</script>