<!DOCTYPE html>
<html>
<head>
	<title>Laporan Transaksi</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
 
	<div class="container">
		<center>
			<h4>Laporan Transaksi</h4>
			<h5><a target="_blank" href="https://www.malasngoding.com/membuat-laporan-…n-dompdf-laravel/">www.malasngoding.com</a></h5>
		</center>
		<br/>
		<table class='table table-bordered'>
			<thead>
				<tr>
                    <th class="text-center" width="5%">No</th>
                    <th class="text-center" width="30%">Kode Transaksi</th>
                    <th class="text-center" width="20%">Nama Agen</th>
                    <th class="text-center" width="20%">Tanggal</th>
                    <th class="text-center" width="10%">Jenis</th>
                    <th class="text-center" width="10%">Valid</th>
                    <th class="text-center" width="30%">Action</th>
				</tr>
			</thead>
			<tbody>
				@forelse ($transaksi as $t)
                        
                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td>{{ $t->kode_transaksi }}</td>
                            <td>{{ $t->nama_agen }}</td>
                            <td class="date" data-date="{{ $t->tanggal }}">{{ $t->tanggal}}</td>
                            <td>{{ $t->jenis }}</td>
                            @if ( $t->valid==0)
                            <td><span class="label label-warning">Belum Valid</span></td>
                            @else
                            <td><span class="label label-success">Sudah Valid</span></td>
                            @endif
                            
                           @if ($t->valid==0)
                           <td >
                            <a href="/transaksi/detail/{{ $t->kode_transaksi }}" class="btn btn-warning btn-label d-inline"><i class="ti ti-pencil-alt"></i><span>Edit</span></a>
                           </td>
                           @else
                           <td>Sudah Divalidasi</td>
                           @endif
                            
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6">Data Tidak ada</td>
                            </tr>
                        @endforelse
			</tbody>
		</table>
 
	</div>
 
</body>
</html>