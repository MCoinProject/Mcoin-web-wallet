@extends('admin_template')

@section('content')

	<div class="block-header">
	    <h2>STAKING</h2>
	</div>

	<!-- Modal Size Example -->
	<div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">                
                <div class="body">
                    <button type="button" class="btn bg-light-blue waves-effect" data-toggle="modal" data-target="#smallModal">STAKE NOW</button>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Modal Size Example -->

    <!-- Modal Dialogs -->
    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Amount to Stake</h4>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" id="amount" class="form-control" placeholder="Enter amount" name="amount">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect">SUBMIT</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCEL</button>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Modal Dialogs -->

    <br>

	<!-- Striped Rows -->
	<div class="row clearfix">
	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	        <div class="card">
	            <div class="header">
	                <h2>STAKES</h2>
	            </div>
	            <div class="body table-responsive">
	                <table class="table table-striped table-hover">
	                    <thead>
	                        <tr>
	                            <th>Amount</th>
	                            <th>Price</th>
	                            <th>Start</th>
	                            <th>Stop</th>
	                            <th>Total Profit</th>
	                            <th>Option</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	{{-- Stakies list goes here --}}
	                    	<tr>
	                    		<td>10 ETP</td>
	                    		<td>USD 200</td>
	                    		<td>15 July 2017, 10:10:10 AM</td>
	                    		<td></td>
	                    		<td>1 ETP</td>
	                    		<td>
	                    			<a href="/stakes/profit" type="button" class="btn btn-info waves-effect">View Profit</a>
	                    		</td>
	                    	</tr>
	                    </tbody>
	                </table>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- #END# Striped Rows -->

@endsection