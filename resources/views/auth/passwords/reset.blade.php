<!DOCTYPE html>
<html>

<head>
    <!-- Header -->
    @include('components.header')
</head>

<body class="signup-page">
    <div class="signup-box">
        <div class="logo">
            <a href="javascript:void(0);">ETP <b>Wallet</b></a>
            <small>Fastest and Most Secured Wallet of All Time</small>
        </div>
        <div class="card">
            <div class="body">
                {{-- Display Status Message --}}
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                
                {{-- Display error message --}}
                @if ( $errors->has('email') || $errors->has('password') )
                    <div class="alert bg-red alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        @if($errors->has('email'))
                            {{ $errors->first('email') }}
                        @else
                            {{ $errors->first('password') }}
                        @endif
                    </div>
                @endif
                
                {{-- Reset Password Form --}}
                <form id="sign_up" method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">

                    {{-- Form Message --}}
                    <div class="msg">Reset Password</div>

                    {{-- Email Field --}}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input id="email" type="email" class="form-control" name="email" placeholder="Email Address" value="{{ $email or old('email') }}" required autofocus>
                        </div>
                    </div>

                    {{-- Password Field --}}                    
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input id="password" type="password" class="form-control" name="password" minlength="6" placeholder="Password" required>
                        </div>
                    </div>

                    {{-- Confirm Password Field --}}                    
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" minlength="6" placeholder="Confirm Password" required>
                        </div>
                    </div>

                    {{-- Reset Password Button --}}                    
                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">RESET PASSWORD</button>

                    {{-- Login Button --}}                    
                    <div class="m-t-25 m-b--5 align-center">
                        <a href="{{ route('login') }}">Back to login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('components.footer')
</body>

</html>