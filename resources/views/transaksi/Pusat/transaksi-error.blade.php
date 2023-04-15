@extends('layouts.main')
@section('isi')
<div class="container">
    <div class="row">
      <div class="col-md-10 mx-auto text-center">
        <h1>Mohon Maaf Data Parfum {{ $error}} Belum Ada Harap masukkan data terlebih dahulu</h1>
        <a href='/transaksi/detail/{{$id}}' >Kembali</a>
      </div>
    </div>
  </div>
@endsection
