@extends('admin_template')

@section('content')

    <div class="block-header">
        <h2>PROFILE</h2>
    </div>

    <!-- Horizontal Layout -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">

                    {{-- Form Message --}}
                    <h2>USER PROFILE</h2>

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
                        
                        {{-- Name Field --}}
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                {{-- <label for="email_address_2">Name</label> --}}
                                <span><i class="material-icons pull-right waves-effect">create</i></span>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">                                        
                                        <input type="text" id="name" class="form-control" placeholder="User Name" name="name" value="{{ Auth::user()->profile->name }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Phone Number Field --}}
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <span><i class="material-icons pull-right waves-effect">contact_phone</i></span>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="phone_number" class="form-control" placeholder="Phone Number" name="phone_number" value="{{ Auth::user()->profile->phone_number }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- <button type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal">MODAL - DEFAULT SIZE</button> --}}

                        {{-- Send Button --}}
                        <div class="row clearfix">
                            <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                <button type="button" class="btn btn-lg btn-primary m-t-15 waves-effect col-sm-3" onclick="updateProfile()">Update</button>
                                <button type="button" class="btn btn-lg bg-blue-grey col-sm-offset-1 m-t-15 waves-effect col-sm-3" data-toggle="modal" data-target="#uploadModal">Change Profile Picture</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Horizontal Layout -->

    <!-- Default Size -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Upload Your Profile Picture Here</h4>
                </div>
                {{-- Profile Picture Field --}}
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="body">
                                <div id="picture_upload" class="dropzone" style="width: 100%; min-height: 200px;">
                                    <div class="dz-message">
                                        <div class="drag-icon-cph">
                                            <i class="material-icons">image</i>
                                        </div>
                                        <h3>Drop image here or click to upload.</h3>
                                        <em>(Max file size is 2MB)</em>
                                    </div>
                                    <div class="fallback">
                                        <input name="file" type="file" multiple />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
       ///add/update support depending on request
       function updateProfile (){

            if($('#name').val() != "" && $('#phone_number').val() != "")
            {
                var apiLink = '/profile/update';
                ///get data from form
                var datas = {
                    'name': $('#name').val(),
                    'phone_number': $('#phone_number').val(),
                };

                ///ajax request to the api
                $.ajax({
                    url: apiLink,
                    type:'post',
                    data: datas,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(result){
                        if(result.success){
                            swal('SUCCESS', result.message, 'success').then(function() {
                                window.location = "/profile";
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
                    }
                });
            }
            else
            {
                swal('FAILED', 'Please make sure to insert your name and phone number', 'error');
            }
            
        }
     </script>
@endsection