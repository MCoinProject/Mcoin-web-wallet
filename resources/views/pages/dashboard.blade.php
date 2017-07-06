@extends('admin_template')

@section('content')

	<div class="block-header">
	    <h2>DASHBOARD</h2>
	</div>

	<!-- Widgets -->
	<div class="row clearfix">
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="info-box-4 hover-expand-effect">
				<div class="icon">
					<i class="material-icons col-teal">equalizer</i>
				</div>
				<div class="content">
					<div class="text">BALANCE</div>
					<div class="number">0.01</div>
				</div>
			</div>
		</div>
	</div>
	<!-- #END# Widgets -->

	<!-- Striped Rows -->
	<div class="row clearfix">
	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	        <div class="card">
	            <div class="header">
	                <h2>HISTORY</h2>
	            </div>
	            <div class="body table-responsive">
	                <table class="table table-striped table-hover">
	                    <thead>
	                        <tr>
	                            <th>#</th>
	                            <th>FIRST NAME</th>
	                            <th>LAST NAME</th>
	                            <th>USERNAME</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <tr>
	                            <th scope="row">1</th>
	                            <td>Mark</td>
	                            <td>Otto</td>
	                            <td>@mdo</td>
	                        </tr>
	                    </tbody>
	                </table>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- #END# Striped Rows -->

@endsection