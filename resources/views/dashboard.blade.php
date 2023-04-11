@extends('layouts.main')
@section('isi')
<div class="row">
	<div class="col-md-3">
		<div class="info-tile tile-orange">
			<div class="tile-icon"><i class="ti ti-shopping-cart-full"></i></div>
			<div class="tile-heading"><span>Orders</span></div>
			<div class="tile-body"><span>2,150</span></div>
			<div class="tile-footer"><span class="text-success">22.5% <i class="fa fa-level-up"></i></span></div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="info-tile tile-success">
			<div class="tile-icon"><i class="ti ti-bar-chart"></i></div>
			<div class="tile-heading"><span>Revenues</span></div>
			<div class="tile-body"><span>$75,100</span></div>
			<div class="tile-footer"><span class="text-danger">12.7% <i class="fa fa-level-down"></i></span></div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="info-tile tile-info">
			<div class="tile-icon"><i class="ti ti-stats-up"></i></div>
			<div class="tile-heading"><span>Earnings</span></div>
			<div class="tile-body"><span>$40,150</span></div>
			<div class="tile-footer"><span class="text-success">5.2% <i class="fa fa-level-up"></i></span></div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="info-tile tile-danger">
			<div class="tile-icon"><i class="ti ti-bar-chart-alt"></i></div>
			<div class="tile-heading"><span>Visitors</span></div>
			<div class="tile-body"><span>12,600</span></div>
			<div class="tile-footer"><span class="text-danger">10.5% <i class="fa fa-level-down"></i></span></div>
		</div>
	</div>
</div>
@endsection
