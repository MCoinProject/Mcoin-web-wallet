@extends('admin_template')

@section('content')

	<div class="block-header">
	    <h2>STAKING</h2>
	</div>

	<!-- Striped Rows -->
	<div class="row clearfix">
	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	        <div class="card">
	            <div class="header">
	                <h2>STAKE LOGS</h2>
	            </div>
	            <div class="body table-responsive">
	                <table class="table table-striped table-hover">
	                    <thead>
	                        <tr>
	                        	<th></th>
	                            <th>Start</th>
	                            <th>Stop</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	{{-- Stakes logs goes here --}}
	                    	<tr>
	                    	</tr>
	                    </tbody>
	                </table>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- #END# Striped Rows -->

@endsection