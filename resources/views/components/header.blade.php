<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>{{ $page_title or "Wallet" }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Favicon-->
<link rel="icon" href="{{ asset('etp_token_fav_ico/favicon.ico') }}" type="image/x-icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

<!-- Bootstrap Core Css -->
<link href="{{ asset('/bower_components/adminbsb-materialdesign/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

<!-- Waves Effect Css -->
<link href="{{ asset('/bower_components/adminbsb-materialdesign/plugins/node-waves/waves.css')}}" rel="stylesheet" />

<!-- Animation Css -->
<link href="{{ asset('/bower_components/adminbsb-materialdesign/plugins/animate-css/animate.css')}}" rel="stylesheet" />

<!-- Dropzone Css -->
<link href="{{ asset('/bower_components/adminbsb-materialdesign/plugins/dropzone/dist/dropzone.css')}}" rel="stylesheet">

<!-- Bootstrap Select Css -->
<link href="{{ asset('/bower_components/adminbsb-materialdesign/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />

<!-- Sweetalert Css -->
<link href="{{ asset('/bower_components/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet" />

{{--  --}}

<!-- Custom Css -->
<link href="{{ asset('/bower_components/adminbsb-materialdesign/css/style.css')}}" rel="stylesheet">

<!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
<link href="{{ asset('/bower_components/adminbsb-materialdesign/css/themes/all-themes.css')}}" rel="stylesheet" />