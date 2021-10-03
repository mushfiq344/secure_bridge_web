@extends('org_admin.layouts.auth')
@section('content')


<div class="card overflow-hidden account-card mx-3">
    <div class="bg-primary p-4 text-white text-center position-relative">
        <h4 class="font-20 m-b-5">Free Register</h4>
        <p class="text-white-50 mb-4">Get your free Organizational Admin Dashboard account now.</p><a href="index.html"
            class="logo logo-admin"><img src="{{asset('admin/images/logo-sm.png')}}" height="24" alt="logo"></a>
    </div>
    <div class="account-card-content">



        @isset($url)
        <form method="POST" action='{{ url("$url/register") }}' aria-label="{{ __('Register') }}">
            @else
            <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                @endisset
                @csrf


                <div class="form-group">
                    <label for="name">Name</label>

                    <div>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">E-Mail Address</label>

                    <div>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>

                    <div>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>

                    <div>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row m-t-20">
                    <div class="col-12 text-right"><button class="btn btn-primary w-md waves-effect waves-light"
                            type="submit">Register</button></div>
                </div>
                <div class="form-group m-t-10 mb-0 row">
                    <div class="col-12 m-t-20">
                        <p class="mb-0">By registering you agree to the Secure Bridges - Dashboard <a href="#"
                                class="text-primary">Terms of Use</a></p>
                    </div>
                </div>
            </form>

    </div>
</div>
<div class="m-t-40 text-center">
    <p>Already have an account ? <a href="{{route('org-admin.login')}}" class="font-500 text-primary">Login</a></p>
    <p>© 2021 Ubitrix - Dashboard. Crafted with <i class="mdi mdi-heart text-danger"></i> by Ubitrix</p>
</div>
@endsection