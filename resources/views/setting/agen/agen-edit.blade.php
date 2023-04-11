@extends('layouts.main')
@section('isi')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Ubah Data Agen</h2>
    </div>
        <div class="panel-body">
            <form action="{{ url('/agen/update/' .$agen->kode_agen) }}" class="form-horizontal row-border" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="col-md-3 control-label">Kode Agen</label>
                    <div class="col-md-6">
                        <input disabled type="text" name="kode_agen"class="form-control" value="{{ $agen->kode_agen }}">
                    </div>
                </div>
                
                <div class="form-group @error('nama_agen')
                has-error
                @enderror">
                    <label class="col-md-3 control-label">Nama Agen</label>
                    <div class="col-md-6">
                        <input type="text" name="nama_agen"class="form-control" value="{{ $agen->nama_agen }}">
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
