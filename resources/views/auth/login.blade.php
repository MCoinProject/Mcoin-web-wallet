<!DOCTYPE html>
<html>

<head>
    <!-- Header -->
    @include('components.header')
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            {{-- <a href="javascript:void(0);">ETP <b>Wallet</b></a> --}}
            <img src="{{ asset('images/ETP_logo.png') }}" class="img-responsive"></img>
            <small>Fastest and Most Secured Wallet of All Time</small>
        </div>
        <div class="card">
            <div class="body">
                {{-- Display error message --}}
                @if ( $errors->has('email') || $errors->has('password') || $errors->has('g-recaptcha-response') )
                    <div class="alert bg-red alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        @if($errors->has('email'))
                            {{ $errors->first('email') }}
                        @elseif($errors->has('password'))
                            {{ $errors->first('password') }}
                        @else
                            {{ $errors->first('g-recaptcha-response') }}
                        @endif
                    </div>
                @endif

                @if ( Session::get('message') && Session::get('message') != "" )
                    <div class="alert bg-red alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        {{Session::get('message')}}
                    </div>
                @endif

                {{-- Login Form --}}
                <form id="sign_in" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    {{-- Form Message --}}
                    <div class="msg">Sign in to start your session</div>

                    {{-- Email Field --}}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="email" placeholder="Email" required autofocus>
                        </div>
                    </div>

                    {{-- Password Field --}}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                    </div>

                    <div class="row">  
                        {{-- captcha --}}
                        <div class="g-recaptcha col-sm-12" data-sitekey="{{env('NOCAPTCHA_SITEKEY')}}"></div>
                    </div>
                    
                    <div class="row">
                        {{-- Remember Me Tickbox --}}
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" id="remember" class="filled-in chk-col-teal" {{ old('remember') ? 'checked' : '' }} />
                            <label for="remember">Remember Me</label>
                        </div>

                        {{-- Sign In Button --}}
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
                        </div>
                    </div>

                    <div class="row m-t-15 m-b--20">
                        {{-- Register Button --}}
                        <div class="col-xs-6">
                            <a href="{{ route('register') }}">Register Now!</a>
                        </div>

                        {{-- Forgot Password Button --}}
                        <div class="col-xs-6 align-right">
                            <a href="{{ route('password.request') }}">Forgot Password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('components.footer')
</body>

</html>