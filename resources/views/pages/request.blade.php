@extends('admin_template')

@section('content')

	<div class="block-header">
	    <h2>TRANSACTIONS</h2>
	</div>

	<!-- Horizontal Layout -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">

                	{{-- Form Message --}}
                    <h2>REQUEST ASSET</h2>

                    {{-- Form Hidden Button --}}
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Reset</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="body">
                    <form class="form-horizontal">
                        
                        {{-- Generate QR Code Field --}}
                        <center>
                            <img src="https://chart.googleapis.com/chart?cht=qr&chs=250x250&chl={{Auth::user()->wallet->address}}" alt="">
                        </center>
                        
                    	{{-- Wallet Address Field --}}
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="email_address_2">Wallet Address</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        {{-- <input type="text" id="wallet_address" class="form-control" placeholder="Your wallet address" name="wallet_address" disabled> --}}
                                        <h5>{{Auth::user()->wallet->address}} <span><i class="material-icons pull-right waves-effect" id="copyBtn" data-clipboard-text="{{Auth::user()->wallet->address}}" onclick="showNoti()">content_copy</i></span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Amount Field --}}
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="password_2">Amount</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" id="amount" class="form-control" placeholder="Enter amount" name="amount">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Email Field --}}
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="password_2">Email</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="email" id="email" class="form-control" placeholder="Enter requested email address" name="email">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Description Field --}}
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="password_2">Description</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="description" class="form-control" placeholder="Descriptions" name="description">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Send Button --}}
                        <div class="row clearfix">
                            <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                <button type="button" class="btn btn-lg btn-primary m-t-15 waves-effect" onclick="sendForm()">SUBMIT</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Horizontal Layout -->

    <script type="text/javascript">

        function showNoti() {
          var notify = $.notify('Address coppied to clipboard!', {
            type: 'success',
            allow_dismiss: true,
            placement: {
                from: "top",
                align: "center"
              },
            timer: 500
          });
        }

        // Request assets from another wallet
        function sendForm (){

          if($('#amount').val() > 0 && $('#email').val() != "")
          {
            var apiLink = '/transactions/request/add';

             // Get data from form
             var datas = {
                'amount': $('#amount').val(),
                'email': $('#email').val(),
                'description': $('#description').val(),
             };

             console.log(datas);

             swal({
               title: 'Request ETP',
               text: 'Request '+$('#email').val()+' for '+$('#amount').val()+' ETP ?',
               showCancelButton: true,
               confirmButtonText: 'Submit',
               showLoaderOnConfirm: true,
               preConfirm: function (result) {
                 return new Promise(function (resolve, reject) {
                   // Ajax request to the api
                   $.ajax({
                      url: apiLink,
                      type:'post',
                      data: datas,
                      headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      success:function(result){
                         resolve(result);
                      }
                   });
                 })
               },
               allowOutsideClick: false
             }).then(function (result) {
               if(result.success){
                  swal('SUCCESS', result.message, 'success').then(function() {
                     window.location = "/wallet";
                  });
               }else{
                  var msg = "";
                  if(typeof result.message === 'object'){
                     for (var key in result.message) {
                        if (result.message.hasOwnProperty(key)) {
                           msg += result.message[key][0]+"<br>";
                        }
                     }
                  }else{
                     msg += result.message;
                  }
                  swal('FAILED', msg, 'error');
               }
             })
          }
          else
          {
            swal('FAILED', 'Please make sure to insert valid email address and amount', 'error');
          }
        }
    </script>

@endsection