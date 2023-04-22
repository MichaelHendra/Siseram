@extends('layouts.main')
@section('isi')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            Tambah atau Ubah Data Transaksi Disini
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <div class="panel panel-default" id="panel-editable">
            <div class="panel-heading">
                <h2>Tabel Transaksi</h2>
                <div class="panel-ctrls"> 
                    <div class="DTTT btn-group pull-left mt-sm mr-3">
                    <a class="btn btn-default DTTT_button_text" id="ToolTables_crudtable_0"href="/transaksi/tambah"><i class="ti ti-plus"></i> <span>New</span></a>
                    </div>
                </div>
            </div>
            <div class="panel-body no-padding">
            
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="crudtable">
                    <thead class="text-center">
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
                    <tbody class="text-center">
                        @php
                            $no=1+(($transact->currentPage()-1)*$transact->perPage()); 
                        @endphp
                        @forelse ($transact as $t)
                         
                        <tr>
                            <td>{{ $no++}}</td>
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
                           <td >
                            <a href="/transaksi/detail/{{ $t->kode_transaksi }}" class="btn btn-success btn-label d-inline"><i class="ti ti-pencil-alt"></i><span>Lihat</span></a>
                           </td>
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
                {{ $transact->links() }}
            </div>
        </div>
    </div>
</div>

@push('date')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    $(document).ready(function() {
        $('.date').each(function() {
            var date = moment($(this).data('date')).format('DD/MM/YYYY');
            $(this).text(date);
        });
    });
   
</script>    
@endpush
@endsection
