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
                
                <form id="sign_up" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <div class="msg">Register a new membership</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" minlength="6" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password_confirmation" minlength="6" placeholder="Confirm Password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="terms" id="terms" class="filled-in chk-col-pink">
                        <label for="terms">I read and agree to the <a href="javascript:void(0);">terms of usage</a>.</label>
                    </div>

                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">SIGN UP</button>

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