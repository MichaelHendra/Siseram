@extends('layouts.main')
@section('isi')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            Laporan Transaksi
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <div class="panel panel-default" id="panel-editable">
            <div class="panel-heading">
                <h2>Tabel Laporan Transaksi</h2>
                {{-- <div class="panel-ctrls"> 
                    <div class="DTTT btn-group pull-left mt-sm mr-3">
                        <a class="btn btn-default DTTT_button_text" id="ToolTables_crudtable_0"href="/transaksi/tambah"><i class="ti ti-plus"></i> <span>New</span></a>
                    </div>
                </div> --}}
            </div>
            <div class="panel-body">
                <div class="form-group">
                        <form action="/lapor/transaksi"  method="POST">
                            @csrf
                        <label class="col-sm-2 control-label">Jangka Tanggal Transaksi</label>
                        <div class="col-sm-8">
                            <div class="input-daterange input-group" id="datepicker-range">
                                <input class="form-control datepicker" name="tanggal1"type="text" id="dtp-1">
                                <span class="input-group-addon">to</span>
                                <input class="form-control datepicker" name="tanggal2"type="text" id="dtp-2">
                                <span class="input-group-addon"></span>
                                {{-- @if ($newdatefrom = null)
                                <input class="form-control datepicker" name="hidden1"type="hidden" id="dtp-1" value="{{ $newdatefrom }}">
                                <input class="form-control datepicker" name="hidden2"type="hidden" id="dtp-1" value="{{ $newdateto }}">
                                @else
                                
                                @endif --}}
                                
                                <button class="form-control btn btn-primary" type="submit">Cari</button>
                            </div>
                        
                        </div>
                    </form>
                    <a href="/lapor/transaksi/cetak" class="btn btn-primary">Cetak</a>
                    </div>
            </div>
           
            <div class="panel-body no-padding">
            
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="crudtable">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center" width="30%">Kode Barang</th>
                            <th class="text-center" width="20%">Nama Barang</th>
                            <th class="text-center" width="20%">Jumlah</th>
                            <th class="text-center" width="10%">Harga Pusat</th>
                            <th class="text-center" width="10%">Harga Agen</th>
                            <th class="text-center" width="10%">Sub Total</th>
                            <th class="text-center" width="10%">Valid</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($transact as $t)
                        
                        {{-- <tr>
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
                        @endforelse --}}
                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td>{{ $t->kode_barang }}</td>
                            <td>{{ $t->nama_barang }}</td>
                            {{-- <td class="date" data-date="{{ $t->tanggal }}">{{ $t->tanggal}}</td> --}}
                            <td>{{ $t->total_brg }}</td>
                            <td>{{ $t->h_beli }}</td>
                            <td>{{ $t->h_agen }}</td>
                            <td>{{ $t->total_harga }}</td>
                            @if ( $t->valid==0)
                            <td><span class="label label-warning">Belum Valid</span></td>
                            @else
                            <td><span class="label label-success">Sudah Valid</span></td>
                            @endif
                        
                            
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6">Data Tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!--end table-->
                
            </div>
        </div>
    </div>
</div>

@push('date')
    <script type="text/javascript" src="{{ asset('assets/plugins/form-daterangepicker/daterangepicker.js') }}"></script>     				<!-- Date Range Picker -->
    <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>      			<!-- Datepicker -->
    <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js') }}"></script>      			<!-- Timepicker -->
    <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script> <!-- DateTime Picker -->
    <script>
            $(document).ready(function(){
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy'
            });
        });

    </script>
@endpush
@endsection
