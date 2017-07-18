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
<script src="{{ asset('/bower_components/adminbsb-materialdesign/js/demo.js')}}"></script>

<!-- Validation Plugin Js -->
<script src="{{ asset('/bower_components/adminbsb-materialdesign/plugins/jquery-validation/jquery.validate.js')}}"></script>

<!-- Dropzone Plugin Js -->
<script src="{{ asset('/bower_components/adminbsb-materialdesign/plugins/dropzone/dist/dropzone.js')}}"></script>

{{-- Clipboard - plugin to copy text to clipboard --}}
<script src="{{ asset('/bower_components/clipboard/dist/clipboard.min.js')}}"></script>

<!-- Bootstrap Notify Plugin Js -->
<script src="{{ asset('/bower_components/adminbsb-materialdesign/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>

{{-- Hide this js if in this pages --}}
@if(!Request::is('login') && !Request::is('register') && !Request::is('password/reset'))
	<!-- Custom Js -->
	<script src="{{ asset('/bower_components/adminbsb-materialdesign/js/admin.js')}}"></script>
    <script src="{{ asset('/bower_components/adminbsb-materialdesign/js/pages/ui/modals.js')}}"></script>
@endif

{{-- Captcha --}}
<script src='https://www.google.com/recaptcha/api.js'></script>

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

	$( document ).ready(function() {

		@if((!Request::is('login') && !Request::is('register') && !Request::is('password/reset')) || Request::is('login'))
			if(localStorage.getItem("theme")){

				console.log('saved theme '+localStorage.getItem("theme"));
				var $body = $('body');

				var existTheme = $('.right-sidebar .demo-choose-skin li.active').data('theme');

				$('.right-sidebar .demo-choose-skin li').removeClass('active');
				$body.removeClass('theme-' + existTheme);

				$body.addClass('theme-' + localStorage.getItem("theme"));
			}
		@endif
	});
	
</script>