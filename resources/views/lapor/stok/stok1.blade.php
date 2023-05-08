@extends('layouts.main')
@section('isi')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            Laporan Stok Parfum
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <h3>Data Stok Agen Yang Ingin Dicari</h3>
        <form action="/lapor/stok/agen" class="form-horizontal row-border" method="POST">
            @csrf
            <select name="nama" id="selector1" class="form-control">
                @foreach ($Agen as $chuu)
                <option value="{{$chuu->kode_agen}}">{{$chuu->nama_agen}}</option>
                @endforeach
            </select>
            <br>
            <button type="submit" class="btn-primary btn">Cari</button>
            <a href="/lapor/stok/cetak" class="btn btn-primary">Cetak</a>
        </form>
       
        <br>
        <div class="panel panel-default" id="panel-editable">
            <div class="panel-heading">
                <h2>Tabel Stok Pafum</h2>
                {{-- <div class="panel-ctrls"> 
                    <div class="DTTT btn-group pull-left mt-sm mr-3">
                    <a class="btn btn-default DTTT_button_text" id="ToolTables_crudtable_0"href="/parfum/tambah"><i class="ti ti-plus"></i> <span>New</span></a>
                    </div>
                </div> --}}
            </div>
            <div class="panel-body no-padding">
            
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="crudtable">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center" width="10%">Nama Barang</th>
                            <th class="text-center" width="20%">Nama Agen</th>
                            <th class="text-center" width="20%">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
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
        </div>
    </div>
</div>
@endsection