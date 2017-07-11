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
                {{-- Display error message --}}
                @if ( $errors->has('email') || $errors->has('password') || $errors->has('name') || $errors->has('phone_number') || $errors->has('g-recaptcha-response'))
                    <div class="alert bg-red alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        @if($errors->has('email'))
                            {{ $errors->first('email') }}
                        @elseif($errors->has('password'))
                            {{ $errors->first('password') }}
                        @elseif($errors->has('name'))
                            {{ $errors->first('name') }}
                         @elseif($errors->has('phone_number'))
                            {{ $errors->first('phone_number') }}
                         @elseif($errors->has('g-recaptcha-response'))
                            {{ $errors->first('g-recaptcha-response') }}
                        @endif
                    </div>
                @endif
                
                {{-- Registration Form --}}
                <form id="sign_up" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    {{-- Form Message --}}
                    <div class="msg">Register a new membership</div>

                    {{-- Name Field --}}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                        </div>
                    </div>

                    {{-- Email Field --}}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                        </div>
                    </div>

                    {{-- Phone Number Field --}}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">contact_phone</i>
                        </span>
                        <div class="form-line">
                            <input type="number" class="form-control" name="phone_number" placeholder="Phone Number" required>
                        </div>
                    </div>

                    {{-- Password Field --}}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" minlength="6" placeholder="Password" required>
                        </div>
                    </div>

                    {{-- Confirm Password Field --}}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password_confirmation" minlength="6" placeholder="Confirm Password" required>
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <input type="checkbox" name="terms" id="terms" class="filled-in chk-col-pink">
                        <label for="terms">I read and agree to the <a href="javascript:void(0);">terms of usage</a>.</label>
                    </div> --}}

                    <div class="row">  
                        {{-- captcha --}}
                        <div class="g-recaptcha col-sm-12" data-sitekey="{{env('NOCAPTCHA_SITEKEY')}}"></div>
                    </div>

                    {{-- Sign Up Button --}}
                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">SIGN UP</button>

                    {{-- Login Button --}}
                    <div class="m-t-25 m-b--5 align-center">
                        <a href="{{ route('login') }}">Already a member?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('components.footer')
</body>

</html>