<?php

// use App\Models\Blog;
// use App\Models\Social;

$blogs = [];
$links = [];
?>

<?php

use Illuminate\Support\Facades\Auth;

$userTypeNames = \App\Models\User::getTypeNames();
$userTypes
= \App\Models\User::getTypes();
if (!empty(Auth::user())) {
    $userType = $userTypeNames[Auth::user()->user_type];
}

?>

<footer class="footer footer-light-left">
    <div class="container">
        <div class="columns is-vcentered">
            <div class="column is-6">
                <div class="mb-20">
                    <img class="small-footer-logo"
                        src="{{asset('frontend/theme/assets/img/logos/logo/logo-bottom.jpeg')}}" alt="">
                </div>
                <div>
                    <span class="moto">Copyright &#169; 2021 Secure Bridges | All Rights Reserved</span>
                    @if(!$agent->isMobile())
                    <nav class="level is-mobile mt-20">
                        <div class="level-left level-social">
                            @foreach ($links as $link)
                            <a href="{{$link->link}}" class="level-item">
                                <span class="icon"><i class="fa {{$link->icon}}"></i></span>
                            </a>

                            @endforeach
                        </div>
                    </nav>
                    @endif
                </div>
            </div>
            @if(!$agent->isMobile())
            <div class="column">
                <div class="footer-nav-right">
                    @guest
                    @else
                    <a class="footer-nav-link capital-text" href="/home">Home</a>
                    @endguest

                    @foreach($blogs as $blog)
                    <a class="footer-nav-link capital-text" href="{{url('pages/'.$blog->title_key)}}" target="_blank">
                        {{ucfirst($blog->title)}}
                    </a>
                    @endforeach

                    @guest
                    <a class="footer-nav-link capital-text" href="{{ route('login') }}">Sign in</a>
                    <a class="footer-nav-link capital-text" href="{{ route('register') }}">Sign up</a>
                    @else

                    @endguest
                </div>
            </div>
            @endif
        </div>
    </div>
</footer>