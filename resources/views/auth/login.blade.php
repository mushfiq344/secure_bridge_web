@extends('theme.frontend.layouts.app')
@section('head')
<style>
#login-card {
    max-width: 414px !important;
    padding-left: 0px !important;
    padding-right: 0px !important;
    background-color: #f0efff !important;
    padding-bottom: 0px !important;
}

.input-field {
    height: 50px !important;
    border-radius: 12px !important;
    background-color: #f0efff;
}

.input-field-icon {
    height: 50px !important;
}

.right-icon {
    padding-right: 2.5rem !important;
    text-decoration: underline;
}

.purple-text {
    color: #573353 !important;
}

.auth-button {
    width: 374px !important;
    height: 60px !important;
    border-radius: 8px !important;
}

.fw-700 {
    font-weight: 700 !important;
}

.fw-500 {
    font-weight: 500 !important;
}

.pr-5rem {
    padding-right: 5rem !important;
}
</style>

@endsection
@section('content')
<div class="auth-outer-alt" style="margin-top: 0px;">

    <div class="columns">


        <div class="column">
            <div class="form-wrapper" id="login-card">

                <div class="form-title">
                    <h3 class="fw-700 purple-text">WELCOME TO <br>
                        SECURE BRIDGES</h3>

                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-inner" style="border-radius: 20px !important;
    background-color: #fff;">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input type="text" id="email" type="email"
                                    class="input is-rounded is-primary-focus input-field  @error('email') is-invalid @enderror "
                                    placeholder="Email address" name="email" value="{{ $email??old('email') }}" required
                                    autocomplete="email" autofocus>
                                <div class="icon is-nedium is-left input-field-icon">
                                    <i class="sl sl-icon-envelope-open"></i>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control has-icons-left">
                                <input id="password" type="password"
                                    class="input is-rounded is-primary-focus input-field @error('password') is-invalid @enderror"
                                    placeholder="Password" name="password" required autocomplete="current-password">
                                <div class="icon is-nedium is-right input-field-icon  right-icon">
                                    <span class="underline pr-5rem fw-500 purple-text">show</span>
                                </div>
                                <div class="icon is-nedium is-left input-field-icon">
                                    <i class="sl sl-icon-lock"></i>
                                </div>

                            </div>
                        </div>
                        @if($redirectUrl)
                        <div class="field">
                            <div class="control has-icons-left">
                                <input id="password" type="text"
                                    class="input is-rounded is-primary-focus input-field @error('redirect_url') is-invalid @enderror"
                                    placeholder="Password" name="redirect_url" value="{{$redirectUrl??''}}" ;
                                    style="display:none">


                            </div>
                        </div>
                        @endif

                        <div class="field pb-5">
                            <div class="control">
                                <label class="checkbox-wrap is-small muted-text">
                                    <input class="d-checkbox" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <span></span>
                                    <span class="purple-text fw-700"> Remember me? </span>
                                </label>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control has-icons-left">
                                <button
                                    class="button is-fullwidth is-rounded primary-btn raised auth-button fw-700">Login</button>
                            </div>
                        </div>

                        <div class="has-text-centered">
                            @if (!$agent->isMobile())
                            <a class="muted-text purple-text fw-500" href="{{ route('password.request') }}">Forgot
                                Password?</a>
                            @endif
                        </div>

                        <div class="form-divider">
                            <!-- <div class="divider-circle">
                                <i class="material-icons">keyboard_arrow_down</i>
                            </div> -->
                        </div>
                        @if (!$agent->isMobile())
                        <div class="social-login">
                            <h4 class="purple-text fw-700">Or login with social media</h4>
                            <div class="login-buttons">
                                <div class="button-wrap">

                                </div>
                                <div class="button-wrap">
                                    <a class="button-inner" href="{{url('auth/google')}}">
                                        <i class="fa fa-google"></i>
                                    </a>
                                </div>
                                <div class="button-wrap">
                                    <a class="button-inner" href="#">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                </div>
                                <div class="button-wrap">

                                </div>

                            </div>
                        </div>
                            @endif
                       
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection