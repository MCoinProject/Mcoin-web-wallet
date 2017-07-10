@extends('admin_template')

@section('content')

	<div class="block-header">
	    <h2>DASHBOARD</h2>
	</div>

	<!-- Widgets -->
	<div class="row clearfix">
		{{-- Balance Widget --}}
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="info-box-4 hover-expand-effect">
				<div class="icon">
					<i class="material-icons col-teal">attach_money</i>
				</div>
				<div class="content">
					<div class="text">BALANCE</div>
					<div class="number">{{ Auth::user()->getTotalBalance() }}</div>
				</div>
			</div>
		</div>

		{{-- Total Transfer Widget --}}
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="info-box-4 hover-expand-effect">
				<div class="icon">
					<i class="material-icons col-teal">attach_money</i>
				</div>
				<div class="content">
					<div class="text">TOTAL TRANSFERED</div>
					<div class="number">{{ Auth::user()->getTotalTransfered() }}</div>
				</div>
			</div>
		</div>

		{{-- Total Received Widget --}}
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="info-box-4 hover-expand-effect">
				<div class="icon">
					<i class="material-icons col-teal">attach_money</i>
				</div>
				<div class="content">
					<div class="text">TOTAL RECEIVED</div>
					<div class="number">{{ Auth::user()->getTotalReceived() }}</div>
				</div>
			</div>
		</div>

		{{-- Real Time ETP Price --}}
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="info-box-4 hover-expand-effect">
				<div class="icon">
					<i class="material-icons col-teal">attach_money</i>
				</div>
				<div class="content">
					<div class="text">ETP PRICE</div>
					<div class="number">0.00</div>
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
	                <h2>TRANSACTION HISTORY</h2>
	            </div>
	            <div class="body table-responsive">
	                <table class="table table-striped table-hover">
	                    <thead>
	                        <tr>
	                            <th>Address</th>
	                            <th>Amount</th>
	                            <th>Type</th>
	                            <th>Date</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	@foreach($transfers as $transfer)
	                        <tr>
	                            <td>{{ $transfer->receiver_address }}</td>
	                            <td>{{ $transfer->amount }}</td>
	                            <td>
	                            	@if($transfer->sender_address == Auth::user()->wallet->address)
	                            	<span class="col-orange">Transfer</span>
	                            	@else
	                            	<span class="col-teal">Receive</span>
	                            	@endif
	                            </td>
	                            <td>{{ Carbon\Carbon::parse($transfer->created_at)->format('d M Y, G:i a') }}</td>
	                        </tr>
	                        @endforeach
	                    </tbody>
	                </table>
	                <div class="col-sm-12">
	                	{{ $transfers->links() }}
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- #END# Striped Rows -->

@endsection