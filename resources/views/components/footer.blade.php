<!-- Jquery Core Js -->
<script src="{{ asset('/bower_components/adminbsb-materialdesign/plugins/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap Core Js -->
<script src="{{ asset('/bower_components/adminbsb-materialdesign/plugins/bootstrap/js/bootstrap.js')}}"></script>

<!-- Select Plugin Js -->
<script src="{{ asset('/bower_components/adminbsb-materialdesign/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

<!-- Slimscroll Plugin Js -->
<script src="{{ asset('/bower_components/adminbsb-materialdesign/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{ asset('/bower_components/adminbsb-materialdesign/plugins/node-waves/waves.js')}}"></script>

<!-- SweetAlert Plugin Js -->
<script src="{{ asset('/bower_components/sweetalert2/dist/sweetalert2.min.js')}}"></script>

<!-- Custom Js -->
<script src="{{ asset('/bower_components/adminbsb-materialdesign/js/admin.js')}}"></script>
{{-- <script src="{{ asset('/bower_components/adminbsb-materialdesign/js/pages/forms/advanced-form-elements.js')}}"></script> --}}

<!-- Demo Js -->
<script src="{{ asset('/bower_components/adminbsb-materialdesign/js/demo.js')}}"></script>

<!-- Validation Plugin Js -->
<script src="{{ asset('/bower_components/adminbsb-materialdesign/plugins/jquery-validation/jquery.validate.js')}}"></script>

<!-- Dropzone Plugin Js -->
<script src="{{ asset('/bower_components/adminbsb-materialdesign/plugins/dropzone/dropzone.js')}}"></script>

<!-- Bitcore Js -->
<script src="{{ asset('/bower_components/bitcore-lib/bitcore-lib.js')}}"></script>

<script type="text/javascript">
	@if(Request::is('register'))
		generateAddress();

	    function generateAddress() {
	        var bitcore = require('bitcore-lib');

	        var privateKey = new bitcore.PrivateKey();
	        var publicKey = new bitcore.PublicKey(privateKey);

	        var privateStr = privateKey.toWIF();
	        var publicStr = privateKey.toPublicKey();
	        var address = publicStr.toAddress().toString();

	        console.log('test');

	        $('#private_key').val(privateStr);
	        $('#public_key').val(publicStr.toString());
	        $('#address').val(address);
	    }
    @endif
</script>