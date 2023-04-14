@extends('layouts.main')
@section('isi')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            Tambah atau Ubah Data Parfum Disini
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <div class="panel panel-default" id="panel-editable">
            <div class="panel-heading">
                <h2>Tabel Parfum</h2>
                <div class="panel-ctrls"> 
                    <div class="DTTT btn-group pull-left mt-sm mr-3">
                    <a class="btn btn-default DTTT_button_text" id="ToolTables_crudtable_0"href="/parfum/tambah"><i class="ti ti-plus"></i> <span>New</span></a>
                    </div>
                    {{-- Mess Button --}}
                    <div class="DTTT btn-group pull-left mt-sm mr-3">
                        <a class="btn btn-default DTTT_button_text" id="ToolTables_crudtable_0"href="/parfum/mess"><i class="ti ti-plus"></i> <span>Mess</span></a>
                    </div>
                </div>
            </div>
            <div class="panel-body no-padding">
            
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="crudtable">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center" width="10%">Kode Barang</th>
                            <th class="text-center" width="20%">Nama</th>
                            <th class="text-center" width="20%">Harga Beli</th>
                            <th class="text-center" width="20%">Harga Agen</th>
                            <th class="text-center" width="25%">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        {{-- <tr>
                            <td>1</td>
                            <td>K parfum</td>
                            <td>parfum</td>
                            <td>beli</td>
                            <td>jual</td>
                            <td>action</td>
                        </tr> --}}
                        @php
                            $no=1+(($parfum->currentPage()-1)*$parfum->perPage()); 
                        @endphp
                        @forelse ($parfum as $p)

                        <tr>
                            <td>{{ $no++}}</td>
                            <td>{{ $p->kode_barang }}</td>
                            <td>{{ $p->nama_barang }}</td>
                            <td>Rp. {{ number_format($p->h_beli )}}</td>
                            <td>Rp. {{ number_format($p->h_agen) }}</td>
                            <td >
                                <a href="/parfum/edit/{{ $p->kode_barang}}" class="btn btn-warning btn-label d-inline"><i class="ti ti-pencil-alt"></i><span>Edit</span></a>
                        
                                    
                                <a class=" btn btn-danger btn-label btn-delete"href="#" data-toggle="tooltip" data-deleteid="{{ $p->kode_barang}}" title='Delete'><i class="ti ti-trash"></i><span>Delete</span></a>
                            
                            </td>
                            
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6">Data Tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $parfum->links() }}
                <!--end table-->
                
            </div>
        </div>
    </div>
</div>

@push('alert')
<script>
    
  
     $(".btn-delete").click(function(e) {
      var id=$(this).attr('data-deleteid');
   
      e.preventDefault();
      swal({
        title: 'Yakin ingin menghapus data?',
        text: "Data dengan kode ini:"+id+" akan dihapus ",
        icon: 'warning',
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          window.location="/parfum/destroy/"+id+""
          swal("Data anda berhasil dihapus", {
            icon: "success",
            });
          // form.submit();
          console.log(id);
        } else {
          swal('Proses Hapus dibatalkan');
        }
      });
    });
  
  
  </script>
@endpush
@endsection
