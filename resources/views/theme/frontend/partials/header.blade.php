<?php

$userTypeNames = \App\Models\User::getTypeNames();
$userTypes
= \App\Models\User::getTypes();
if (!empty(Auth::user())) {
    $userType = $userTypeNames[Auth::user()->user_type];
}

use Illuminate\Support\Facades\Auth;

$blogs = [];
$links = [];
?>

@if (!$agent->isMobile())
<nav class="navbar navbar-wrapper navbar-default navbar-fade is-transparent" style="background-color: #56206c;">
    <div class="container">
        <!-- Brand -->
        <div class="navbar-brand">

            @include('theme.frontend.partials.sidebar')
            <!--<a id="navigation-trigger" class="navbar-item hamburger-btn" href="javascript:void(0);">
                        <span class="menu-toggle">
                            <span class="icon-box-toggle">
                                <span class="rotate">
                                    <i class="icon-line-top"></i>
                                    <i class="icon-line-center"></i>
                                    <i class="icon-line-bottom"></i>
                                </span>
                            </span>
                        </span>
                    </a>-->

            <!-- Responsive toggle -->
            <!-- <div class="custom-burger" data-target="">
                <a id="" class="responsive-btn" href="javascript:void(0);">
                    <span class="menu-toggle">
                        <span class="icon-box-toggle">
                            <span class="rotate">
                                <i class="icon-line-top"></i>
                                <i class="icon-line-center"></i>
                                <i class="icon-line-bottom"></i>
                            </span>
                        </span>
                    </span>
                </a>
            </div> -->
            <!-- /Responsive toggle -->
        </div>

        <!-- Navbar menu -->
        <div class="navbar-menu">
            <!-- Navbar Start -->
            <div class="navbar-start">
                <!-- Navbar item -->


                @foreach($blogs as $blog)
                <!-- <a class="navbar-item is-slide" href="{{url('pages/'.$blog->title_key)}}" target="_blank">
                    <h5 class="text-light">{{ucfirst($blog->title)}}</h5>
                </a> -->
                @endforeach

                @guest

                @endguest
            </div>


            <!-- Navbar end -->
            <div class="navbar-end">
                @guest
                @else
                <!-- Search button -->
                <div class="navbar-item">
                    <!-- <a class="navbar-item is-slide" href="/startups">
                        <i class="fa fa-search"></i>
                    </a> -->


                </div>
                <div class="navbar-item">

                    <!-- <a class="navbar-item is-slide" href="/{{$userType}}/dashboard">
                        <i class="fa fa-home"></i>
                    </a> -->
                </div>
                @if(Auth::user()->type!=$userTypes['User'])
                <div class="navbar-item">

                    <!-- <a class="navbar-item is-slide" href="/{{$userType}}/dashboard/chatting">
                        <i class="fa fa-envelope-open"></i>
                    </a> -->
                </div>
                @endif
                @endguest
                @guest
                <!-- Signup button -->
                <div class="navbar-item">
                    <a id="#signup-btn" href="{{ route('register') }}"
                        class="button button-cta btn-outlined is-bold btn-align primary-btn rounded raised">
                        Sign Up
                    </a>
                </div>
                @else
                <!-- Signup button -->
                <div class="navbar-item">

                    <div class="button btn-align has-icon-right primary-btn btn-outlined is-drop"> <i
                            class="fa fa-user-circle" style="font-size:30px;color:#fff;"></i> <i
                            class="sl sl-icon-arrow-down is-icon-xs"></i>
                        <div class="dropContain">
                            <div class="dropOut">
                                <ul>

                                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                                                class="fa fa-sign-out" aria-hidden="true"></i> Log Out</a>
                                    </li>



                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            </div>
                            </ul>
                        </div>
                    </div>
                </div>


            </div>
            @endguest
        </div>
    </div>
    </div>
</nav>
@endif