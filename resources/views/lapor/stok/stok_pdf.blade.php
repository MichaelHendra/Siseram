<!DOCTYPE html>
<html>
<head>
	<title>Laporan Stok</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
 
	<div class="container">
		<center>
			<h4>Laporan Stok</h4>
		</center>
		<br/>
		<table class='table table-bordered'>
			<thead>
				<tr>
                    <th class="text-center" width="5%">No</th>
                    <th class="text-center" width="10%">Nama Barang</th>
                    <th class="text-center" width="20%">Nama Agen</th>
                    <th class="text-center" width="20%">Jumlah</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($STok as $item)
                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td>{{$item->nama_barang}}</td>
                            <td>{{$item->nama_agen}}</td>
                            <td>{{$item->jumlah}}</td>
                        </tr>
                            
                @endforeach
			</tbody>
		</table>
 
	</div>
 
</body>
</html>