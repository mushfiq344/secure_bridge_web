@extends('org_admin.layouts.auth')
@section('content')
<div class="card overflow-hidden account-card mx-3">
    <div class="bg-primary p-4 text-white text-center position-relative">
        <h4 class="font-20 m-b-5">Welcome Back !</h4>
        <p class="text-white-50 mb-4">Sign in to continue to Organizational Admin Dashboard.</p><a href="index.html"
            class="logo logo-admin"><img src="{{asset('admin/images/logo-sm.png')}}" height="24" alt="logo"></a>
    </div>
    <div class="account-card-content">
        @isset($url)
        <form method="POST" action='{{ url("$url/login") }}' aria-label="{{ __('Login') }}">
            @else
            <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                @endisset
                @csrf

                <div class="form-group">
                    <label for="email">{{ __('E-Mail Address') }}</label>


                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>


                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>

                <div class="form-group">

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                </div>

                <div class="form-group">

                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Login</button>

                    @if (Route::has('org-admin.password.request'))
                    <a class="btn btn-link" href="{{ route('org-admin.password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                    @endif

                </div>
            </form>
    </div>
</div>
<div class="m-t-40 text-center">
    <p>Don't have an account ? <a href="{{route('org-admin.register')}}" class="font-500 text-primary">Signup now</a>
    </p>
    <p>© 2021 Ubitrix - Dashboard. Crafted with <i class="mdi mdi-heart text-danger"></i> by Ubitrix</p>
</div>
@endsection