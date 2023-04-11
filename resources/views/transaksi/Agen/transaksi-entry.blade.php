
@extends('layouts.main')
@section('isi')

<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Input Data Transaksi</h2>
    </div>
        <div class="panel-body">
            {{-- <div class="DTTT btn-group pull-left mt-sm mr-3">
                <a class="btn btn-default DTTT_button_text" id="ToolTables_crudtable_0"href="/tes/del"><i class="ti ti-plus"></i> <span>Mess</span></a>
            </div> --}}
            
            <form action="{{ url('/transaksi/store') }}" class="form-horizontal row-border" method="POST">
                @csrf
                <div class="form-group">
                    <label class="col-md-3 control-label">Kode Agen/Nama Agens</label>
                    <div class="col-md-6">
                        <select class="form-control" name="kode_agen" id="source">
                                @forelse ($agen as $a)
                                <option value="{{$a->kode_agen }}">{{ $a->nama_agen }}</option>
                                @empty         
                                <option value="">Kosong</option>
                                @endforelse
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dtp-1" class="col-md-3 control-label">Tanggal</label>
                    <div class="col-sm-8">
                        <input class="form-control datepicker" name="tanggal"type="text" id="dtp-1">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Jenis</label>
                    <div class="col-md-6">
                        <select class="form-control" name="jenis" id="source">
                            <option value="Masuk">Masuk</option>
                            <option value="Setor">Setor</option>
                            <option value="Retur">Retur</option>
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
