@extends('layouts.main')
@section('isi')
<div class="row">
	<div class="col-md-3">
		<div class="info-tile tile-orange">
			<div class="tile-icon"><i class="ti ti-clipboard"></i></div>
			<div class="tile-heading"><span>Transaksi Belum Valid</span></div>
			<div class="tile-body"><span>{{ $noValid }}</span></div>
			
		</div>
	</div>
	<div class="col-md-3">
		<div class="info-tile tile-success">
			<div class="tile-icon"><i class="ti ti-check-box"></i></div>
			<div class="tile-heading"><span>Transaksi Tervalidasi</span></div>
			<div class="tile-body"><span>{{ $valid}}</span></div>
			
		</div>
	</div>
	<div class="col-md-3">
		<div class="info-tile tile-info">
			<div class="tile-icon"><i class="ti ti-package"></i></div>
			<div class="tile-heading"><span>Total Jenis Parfum</span></div>
			<div class="tile-body"><span>{{ $parfum }}</span></div>
			
		</div>
	</div>
	<div class="col-md-3">
		<div class="info-tile tile-info">
			<div class="tile-icon"><i class="ti ti-user"></i></div>
			<div class="tile-heading"><span>Total Agen</span></div>
			<div class="tile-body"><span>{{ $agen }}</span></div>
		</div>
	</div>
</div>
@endsection
