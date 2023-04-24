@extends('layouts.main')
@section('isi')

<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Ubah Data Transaksi</h2>
    </div>
        <div class="panel-body">
            {{-- <div class="DTTT btn-group pull-left mt-sm mr-3">
                <a class="btn btn-default DTTT_button_text" id="ToolTables_crudtable_0"href="/tes/del"><i class="ti ti-plus"></i> <span>Mess</span></a>
            </div> --}}
            
            <form action="/transaksi/agen/detail/tambah" class="form-horizontal row-border" method="POST">
                {{-- @method('PUT') --}}
                @csrf
                <div class="form-group">
                    <label class="col-md-3 control-label mr-3">Kode Transaksi</label>
                    <div class="col-md-6">
                        <input  type="text" name="kode_transaksi"class="form-control" value="{{ $ngeng->kode_transaksi }}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Kode Agen/Nama Agen</label>
                    <div class="col-md-6">
                        @if ($ngeng->valid==1)
                            <input class="form-control" name="kode_agen"type="text" id="dtp-1" value={{ $waro[0]->nama_agen }} readonly>
                        @else
                            <input class="form-control" name="kode_agen"type="text" id="dtp-1" value={{ $waro[0]->nama_agen }} readonly>
                        @endif
                    </div>
                </div>
                {{-- <div class="form-group">
                    <label class="col-md-3 control-label mr-3">Tanggal</label>
                    <div class="col-md-6">
                        <input disabled type="text" name="tanggal"class="form-control date" data-date="{{ $transact->tanggal }}" value="{{ $transact->tanggal }}">
                    </div>
                </div> --}}
                <div class="form-group">
                    <label for="dtp-1" class="col-md-3 control-label">Tanggal</label>
                    <div class="col-sm-8">
                        <input class="form-control datepicker" name="tanggal"type="text" id="dtp-1" value="{{ $ngeng->tanggal }}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Jenis</label>
                    <div class="col-md-6">
                            <input class="form-control" name="kode_agen"type="text" id="dtp-1" value={{ $ngeng->jenis }} readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Valid</label>
                    <div class="col-md-6">
                        @if ($ngeng->valid==1)
                        <input class="form-control" name="valid"type="text" id="dtp-1" value="Sudah Valid" readonly>
                        @else
                        <input class="form-control" name="valid"type="text" id="dtp-1" value="Belum Valid" readonly>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Tambah Parfum</label>
                    <div class="col-md-6">
                        <select class="form-control" name="kode_barang" id="source">
                            @forelse ($par as $kol)
                            <option value="{{$kol->kode_barang}}">{{$kol->nama_barang}}</option>    
                            @empty
                            <option value="">Kosong</option>
                            @endforelse

                        </select>
                    </div>
                </div>
                
                @if ($ngeng->valid==0)
                    <div class="form-group">
                        <label class="col-md-3 control-label mr-3">Jumlah</label>
                        <div class="col-md-6">
                            <input type="text" name="jumlah"class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button name="simpan" type="submit" class="btn btn-primary">Tambah Barang</button>
                        </div>
                    </div> 
                @endif

                <div class="panel-footer">

                    <div class="panel-body no-padding">
                    @if ($ngeng->valid==0)
                        
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="crudtable">
                            <thead class="text-center">
                                <tr>
                                    <th class="text-center" width="5%">No</th>
                                    <th class="text-center" width="30%">Nama Barang</th>
                                    <th class="text-center" width="20%">Nama Agen</th>
                                    <th class="text-center" width="20%">Jumlah</th>
                                    <th class="text-center" width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($det as $ho)
                                <tr>
                                    
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $ho->nama_barang}}</td>
                                    <td>{{ $ho->nama_agen }}</td>
                                    <td>{{ $ho->jumlah}}</td>
                                    <td><a class=" btn btn-danger btn-label btn-delete"href="#" data-toggle="tooltip" data-trNum="{{ $ho->kode_transaksi }}" data-deleteName="{{ $ho->nama_barang }}" data-deleteid="{{ $ho->kode_barang }}" title='Delete'><i class="ti ti-trash"></i><span>Delete</span></a></td>
                                </tr>     
                                    @empty
                                <tr>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td> 
                                    @endforelse
                                    
                                </tr>
                                {{-- @empty
                                    <tr>
                                        <td colspan="6">Data Tidak ada</td>
                                    </tr>
                                @endforelse --}}
                            </tbody>
                        </table>
                    @else
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="crudtable">
                        <thead class="text-center">
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th class="text-center" width="30%">Nama Barang</th>
                                <th class="text-center" width="20%">Nama Agen</th>
                                <th class="text-center" width="20%">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse ($det as $ho)
                            <tr>
                                
                                <td>{{ $loop->iteration}}</td>
                                <td>{{ $ho->nama_barang}}</td>
                                <td>{{ $ho->nama_agen }}</td>
                                <td>{{ $ho->jumlah}}</td>
                            </tr>     
                                @empty
                            <tr>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td> 
                                @endforelse
                                
                            </tr>
                            {{-- @empty
                                <tr>
                                    <td colspan="6">Data Tidak ada</td>
                                </tr>
                            @endforelse --}}
                        </tbody>
                    </table>
                    @endif
                        <!--end table-->
                        
                    </div>
                </div>
              
                
            </form>
           
           
           @if ($ngeng->valid==0)
               
                <form action={{ url('/transaksi/agen/detail/masuk/'.$ngeng->kode_transaksi) }} method="POST">
                    @csrf
                  
                    <input class="form-control" name="setor_ke"type="hidden" id="dtp-1" value={{ $waro69[0]->kode_agen }} >
                    
                    <div class="col-md-6">
                        <input  type="hidden" name="kode_transaksi"class="form-control" value="{{ $ngeng->kode_transaksi }}">
                    </div>
                    <br>
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                    <button name="simpan" type="submit" class="btn btn-primary btn-valid" data-toggle="tooltip" title='Valid'>Validasi</button>
                            </div>
                        </div>
                </form>
          
           @endif
                            
    </div>
</div>
@push('date')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
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
@push('notif')
<script>
    $(".btn-valid").click(function(e) {
    var form = $(this).closest("form");
    var name = $(this).data("name");
    e.preventDefault();
    swal({
      title: 'Yakin ingin Validasi data?',
      text: 'Data ini akan divalidasi.Setelah itu,data tidak bisa diubah/dihapus',
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    })
    .then((willValid) => {
      if (willValid) {
        form.submit();
      } else {
        swal('Proses Validasi dibatalkan');
      }
    });
  });
  
  </script>
@endpush
@push('alert')
<script>
$(".btn-delete").click(function(e) {
    var id=$(this).attr('data-deleteid');
    var name=$(this).attr('data-deleteName');
    var trNum=$(this).attr('data-trNum');
    e.preventDefault();
    swal({
      title: 'Yakin ingin menghapus data?',
      text: "Data dengan dengan nama :"+name+" akan dihapus ",
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    })
    
    .then((willDelete) => {
      if (willDelete) {
        window.location="/transaksi/agen/detail/hapus/"+trNum+"/"+id+""
        swal("Data anda berhasil dihapus", {
          icon: "success",
          });
        // form.submit();
        console.log(trNum);
      } else {
        swal('Proses Hapus dibatalkan');
      }
    });
  });


</script>
@endpush
@endsection
