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

{{-- <script src="{{ asset('/bower_components/adminbsb-materialdesign/js/pages/forms/advanced-form-elements.js')}}"></script> --}}

<!-- Demo Js -->
{{-- <script src="{{ asset('/bower_components/adminbsb-materialdesign/js/demo.js')}}"></script> --}}

<!-- Validation Plugin Js -->
<script src="{{ asset('/bower_components/adminbsb-materialdesign/plugins/jquery-validation/jquery.validate.js')}}"></script>

<!-- Dropzone Plugin Js -->
<script src="{{ asset('/bower_components/adminbsb-materialdesign/plugins/dropzone/dist/dropzone.js')}}"></script>

<!-- Bitcore Js -->
<script src="{{ asset('/bower_components/bitcore-lib/bitcore-lib.js')}}"></script>

{{-- Clipboard - plugin to copy text to clipboard --}}
<script src="{{ asset('/bower_components/clipboard/dist/clipboard.min.js')}}"></script>

<!-- Bootstrap Notify Plugin Js -->
<script src="{{ asset('/bower_components/adminbsb-materialdesign/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>

<!-- Custom Js -->
<script src="{{ asset('/bower_components/adminbsb-materialdesign/js/admin.js')}}"></script>

<script type="text/javascript">

	@if(Request::is('profile'))
		Dropzone.autoDiscover = false;
		$("#picture_upload").dropzone({
			paramName: 'profile_picture',
			url: '/profile/picture/update',
			clickable: true,
			enqueueForUpload: true,
			maxFilesize: 2, // 2mb
			uploadMultiple: false,
			dictDefaultMessage: "Drag your images",
			// addRemoveLinks: true,
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
		});

		$("#uploadModal").on("hidden.bs.modal", function () {
		    window.location = "/profile";
		});
	@endif

	@if(Request::is('transactions/request'))
		console.log('test');
		new Clipboard('#copyBtn', {
			target: function(trigger) {
				console.log('COPPIED');
			}
		});
	@endif

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