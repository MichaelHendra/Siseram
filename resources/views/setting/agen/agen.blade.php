@extends('layouts.main')
@section('isi')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            Tambah atau Ubah Data Agen Disini
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <div class="panel panel-default" id="panel-editable">
            <div class="panel-heading">
                <h2>Tabel Agen</h2>
                <div class="panel-ctrls"> 
                    <div class="DTTT btn-group pull-left mt-sm mr-3">
                    <a class="btn btn-default DTTT_button_text" id="ToolTables_crudtable_0"href="/agen/tambah"><i class="ti ti-plus"></i> <span>New</span></a>
                    </div>
                </div>
            </div>
            <div class="panel-body no-padding">
            
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="crudtable">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center" width="20%">Kode Agen</th>
                            <th class="text-center" width="30%">Nama Agen</th>
                            <th class="text-center" width="20%">Status</th>
                            <th class="text-center" width="50%">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($agen as $a)

                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td>{{ $a->kode_agen }}</td>
                            <td>{{ $a->nama_agen }}</td>
                            <td>@if ($a->status == 0)
                                Agen
                                @else
                                Pusat
                            @endif</td>
                            <td >
                                <a href="/agen/edit/{{ $a->kode_agen }}" class="btn btn-warning btn-label d-inline"><i class="ti ti-pencil-alt"></i><span>Edit</span></a>
                                <a class=" btn btn-danger btn-label btn-delete"href="#" data-toggle="tooltip" data-deleteid="{{ $a->kode_agen }}" title='Delete'><i class="ti ti-trash"></i><span>Delete</span></a>
                            </td>
                            
                        </tr>
                        @empty
                            <tr>
                                <td colspan="4">Data Tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
          window.location="/agen/destroy/"+id+""
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
