@extends('layouts.main')
@section('isi')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Input Data Parfum</h2>
    </div>
        <div class="panel-body">
            <form action="{{ url('/parfum/store') }}" id="parfum-form" class="form-horizontal row-border" method="POST">
                @csrf
                <div class="form-group @error('kode_barang')
                    has-error
                @enderror">
                    <label class="col-md-3 control-label">Kode Barang</label>
                    <div class="col-md-6">
                        <input type="text" name="kode_barang"class="form-control"required autofocus value="{{ old('kode_barang') }}">
                    </div>
                @error('kode_barang')
                <div class="col-md-3">
                    <p class="help-block"><i class="fa fa-times-circle"></i>
                        Kode Barang tidak boleh sama dengan kode yang sudah ada</p>
                </div>
                @enderror
                </div>
                <div class="form-group @error('nama_barang')
                has-error
                @enderror">
                    <label class="col-md-3 control-label">Nama Barang</label>
                    <div class="col-md-6">
                        <input type="text" name="nama_barang"class="form-control" value="{{ old('nama_barang') }}">
                    </div>
                    @error('nama_barang')
                    <div class="col-md-3">
                        <p class="help-block"><i class="fa fa-times-circle"></i>
                            Field ini tidak boleh kosong</p>
                    </div>
                    @enderror
                </div>
                <div class="form-group @error('h_beli')
                has-error
                @enderror">
                    <label class="col-md-3 control-label">Harga Barang</label>
                    <div class="col-md-6">
                        <input type="text" name="h_beli"class="form-control" value="{{ old('h_beli') }}">
                    </div>
                    @error('h_beli')
                    <div class="col-md-3">
                        <p class="help-block"><i class="fa fa-times-circle"></i>
                            Field ini tidak boleh kosong</p>
                    </div>
                    @enderror
                </div>
                <div class="form-group @error('h_agen')
                has-error
                @enderror">
                    <label class="col-md-3 control-label">Harga Agen</label>
                    <div class="col-md-6">
                        <input type="text" name="h_agen"class="form-control" value="{{ old('h_agen') }}">
                    </div>
                    @error('h_agen')
                    <div class="col-md-3">
                        <p class="help-block"><i class="fa fa-times-circle"></i>
                            Field ini tidak boleh kosong</p>
                    </div>
                    @enderror
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button name="simpan" type="submit" id="tambah-data" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
    </div>
</div>
@push('notif')
    <script>
    $('#parfum-form').on('submit', function () {
        $("#tambah-data").attr("disabled",true);
    });
    </script>
@endpush
@endsection
