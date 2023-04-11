@extends('layouts.main')
@section('isi')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Input Data Agen</h2>
    </div>
        <div class="panel-body">
            <form action="{{ url('/agen/store') }}" class="form-horizontal row-border" method="POST">
                @csrf
                <div class="form-group @error('kode_agen')
                    has-error
                @enderror">
                    <label class="col-md-3 control-label">Kode Agen</label>
                    <div class="col-md-6">
                        <input type="text" name="kode_agen"class="form-control"required autofocus value="{{ old('kode_agen') }}">
                    </div>
                @error('kode_agen')
                <div class="col-md-3">
                    <p class="help-block"><i class="fa fa-times-circle"></i>
                        Kode Agen tidak boleh sama dengan kode yang sudah ada</p>
                </div>
                @enderror
                </div>
                <div class="form-group @error('nama_agen')
                has-error
                @enderror">
                    <label class="col-md-3 control-label">Nama Agen</label>
                    <div class="col-md-6">
                        <input type="text" name="nama_agen"class="form-control" value="{{ old('nama_agen') }}">
                    </div>
                    @error('nama_agen')
                    <div class="col-md-3">
                        <p class="help-block"><i class="fa fa-times-circle"></i>
                            Field ini tidak boleh kosong</p>
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Status</label>
                    <div class="col-md-6">
                        <select name="status" id="selector1" class="form-control">
                            <option value="0">Agen</option>
                            <option value="1">Pusat</option>
                        </select>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button name="simpan" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
    </div>
</div>

@endsection
