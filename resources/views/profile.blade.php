@extends('layouts.main')
@section('isi')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Ubah Password</h2>
    </div>
        <div class="panel-body">
            <form action="{{ url('/updateUser/' .$user->id) }}" id="agen-form" class="form-horizontal row-border" method="POST">
            {{-- <form id="agen-form" class="form-horizontal row-border" >   --}}
                @method('PUT')
                @csrf
                <div class="form-group @error('kode_agen')
                    has-error
                @enderror">
                    <label class="col-md-3 control-label">Username</label>
                    <div class="col-md-6">
                        <input type="text" name="username"class="form-control"required autofocus value="{{ $user->username }}" disabled>
                    </div>
               
                </div>
                <div class="form-group 
                @error('password')
                has-error
                @enderror">
                    <label class="col-md-3 control-label">Password</label>
                    <div class="col-md-6">
                        <input type="password" name="password"class="form-control" value="{{ old('password') }}">
                    </div>
                    @error('password')
                    <div class="col-md-3">
                        <p class="help-block"><i class="fa fa-times-circle"></i>
                            Field ini tidak boleh kosong</p>
                    </div>
                    @enderror
                </div>
                
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button name="simpan" type="submit" class="btn btn-primary ubahpw">Submit</button>
                        </div>
                    </div>
                </div>
            </form> 
            {{-- data-trNum="{{ $ho->kode_transaksi }}" data-deleteName="{{ $ho->nama_barang }}" data-deleteid="{{ $ho->kode_barang }}"  --}}
    </div>
</div>
@push('notif')
    <script>
    $('#agen-form').on('submit', function () {
        $("#tambah-data").attr("disabled",true);
    });
    </script>
@endpush
{{-- @push('alert') 
<script>
    $(".ubahpw").click(function(e) {
    var form = $(this).closest("form");
    var name = $(this).data("name");
    e.preventDefault();
    swal({
      title: 'Yakin ingin ganti password?',
      text: 'Password akan diubah',
      icon: 'info',
      buttons: true,
      dangerMode: true,
    })
    .then((willValid) => {
      if (willValid) {
        $("#btn-valid").attr("disabled",true);
        form.submit();
      } else {
        swal('Update Password Dibatalkan dibatalkan');
      }
    });
  });
</script>
 
@endpush --}}
@endsection
