<?php

namespace App\Http\Controllers;

use App\Models\Agen;
use App\Models\Detail;
use App\Models\Parfum;
use App\Models\Stok;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function detailTapil(string $id)
    {

        $transact = Transaksi::find($id);

        $namaAgen = Transaksi::find($id)
            ->join('tb_agen', 'tb_agen.kode_agen', '=', 'tb_transaksi.kode_agen')
            ->where('tb_transaksi.kode_transaksi', $id)
            ->get('tb_agen.nama_agen');

        $barang = Parfum::all();

        $viewDetailbarang = Detail::join('tb_transaksi', 'tb_transaksi.kode_transaksi', '=', 'tb_transaksi_detail.kode_transaksi')
            ->join('tb_parfum', 'tb_transaksi_detail.kode_barang', '=', 'tb_parfum.kode_barang')
            ->join('tb_agen', 'tb_transaksi.kode_agen', '=', 'tb_agen.kode_agen')
            ->where('tb_transaksi.kode_transaksi', $id)
            ->select('tb_transaksi.kode_transaksi', 'tb_parfum.nama_barang', 'tb_agen.nama_agen', 'tb_transaksi_detail.jumlah', 'tb_parfum.kode_barang','tb_parfum.h_beli','tb_transaksi_detail.harga')
            ->get();

        $agen = Agen::all();

        return view('transaksi/Pusat/transaksi-detail', [
            'transact' => $transact,
            'Nama' => $namaAgen,
            'parfum' => $barang,
            'DataBarang' => $viewDetailbarang,
            'agen' => $agen,
        ]);
    }

    public function detailProses(Request $request)
    { //detail/tambah
        $this->validate($request, [
            'kode_transaksi' => 'required',
            'kode_barang' => 'required',
            'jumlah' => 'required',
        ]);
        $hargaParfum = Parfum::where('kode_barang','=',$request->kode_barang)->select('h_beli')->get()->first();
        $jumlahParfum = $request->jumlah;
        $hargaPusat = $jumlahParfum * $hargaParfum->h_beli;

        Detail::create([
            'kode_transaksi' => $request->kode_transaksi,
            'kode_barang' => $request->kode_barang,
            'jumlah' => $request->jumlah,
            'harga' => $hargaPusat,
        ]);
        return redirect('/transaksi/detail/' . $request->kode_transaksi)->with('success', 'Data berhasil ditambahkan');

    }

    public function detailDelete(string $trNum, string $id)
    {
        $detail = Detail::where('kode_transaksi', $trNum)->where('kode_barang', $id);

        $detail->delete();
        return redirect('/transaksi/detail/' . $trNum)->with('success', 'Data berhasil dihapus');
    }
    
    public function detailmasuk(Request $request)
    {
        $cekDetail = Detail::where('kode_transaksi', $request->kode_transaksi)->get();
        if($cekDetail->isEmpty()){
            toast('Mohon Untuk Mengisi Barang Terlebih Dahulu', 'error')->position('center-end');
            return redirect('/transaksi/detail/' . $request->kode_transaksi);
        }else{
        $detailPro = Detail::join('tb_transaksi', 'tb_transaksi.kode_transaksi', '=', 'tb_transaksi_detail.kode_transaksi')
        ->Where('tb_transaksi_detail.kode_transaksi', $request->kode_transaksi)
        ->select('tb_transaksi.kode_agen', 'tb_transaksi.jenis', 'tb_transaksi_detail.kode_barang', 'tb_transaksi_detail.jumlah')->get();
        $stok = Stok::where('kode_barang', '=', $detailPro[0]->kode_barang)->select('kode_barang', 'jumlah')->get()->first();
        $tbStok = Stok::select('kode_agen')->get()->first();
        $trJenis = Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->select('jenis')->get()->first();
        if ($trJenis->jenis == "Masuk") {
            foreach ($detailPro as $item) {

                $cekStok = Stok::where('kode_barang', '=', $item->kode_barang)->exists();
                $stok = Stok::where('kode_barang', '=', $item->kode_barang)->select('kode_barang', 'jumlah')->get()->first();

                if (is_null($tbStok) || !$cekStok) { //tb stok kosong    //pasti onok bug e
                
                    Stok::create([
                        'kode_agen' => $item->kode_agen,
                        'kode_barang' => $item->kode_barang,
                        'jumlah' => $item->jumlah,
                    ]); //stok
                    Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->update(['valid' => 1]);
                }
                //kode barang kosong
                else {

                    $jmlBrg = Detail::where('kode_barang', '=', $item->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get()->first();
                    $jmlStok = $stok->jumlah;

                    $proses = $jmlStok + $jmlBrg->jumlah;
                    Stok::where('kode_agen', $item->kode_agen)->where('kode_barang', $item->kode_barang)->update(['jumlah' => $proses]);
                    Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->update(['valid' => 1]);
                }
            }
        } else if ($trJenis->jenis == "Setor") { //kode barang kosong

            // error handling
            // barang a barang b
            // jika barang a kosong barang b cancel update b
            // error handling
            $cekError = false;
            $count = 0;
            $tbDetail = Detail::where('kode_transaksi', $request->kode_transaksi);
            $htgBrg = $tbDetail->count();

            foreach ($detailPro as $item) {
                $cekStok = Stok::where('kode_barang', '=', $item->kode_barang)->exists();
                $errorStok = Parfum::where('kode_barang', $item->kode_barang)->select('kode_barang', 'nama_barang')->get();

                if (is_null($tbStok) || !$cekStok) { //tb stok kosong    //pasti onok bug e
                    // dd($cekStok);
                    toast('Barang "' . $errorStok[0]->nama_barang . '" Belum ada di Stok', 'error')->position('center-end');
                    return redirect('/transaksi/detail/' . $request->kode_transaksi);
                } else if ($cekStok) {
                    $count++;
                    if ($htgBrg == $count) {
                        $cekError = true;
                    }
                }
            }
            $jmlStok = false;
            $count = 0;
            $tbDetail = Detail::where('kode_transaksi', $request->kode_transaksi);
            $htgBrg = $tbDetail->count();
            if ($cekError) {
                foreach ($detailPro as $item) {

                    $stok = Stok::where('kode_barang', '=', $item->kode_barang)->select('kode_barang', 'jumlah')->get();
                    $detail = Detail::where('kode_barang', '=', $item->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get();
                    $jmlBrg = $detail[0]->jumlah;
                    $jmlStok = $stok[0]->jumlah;
                    $proses = $jmlStok - $jmlBrg;

                    $cekStok = Stok::where('kode_barang', '=', $item->kode_barang)->exists();
                    $errorStok = Parfum::where('kode_barang', $item->kode_barang)->select('kode_barang', 'nama_barang')->get();

                    if ($proses < 0) { //tb stok kosong    //pasti onok bug e
                        toast('Jumlah Barang "' . $errorStok[0]->nama_barang . '" yang disetorkan melebihi Jumlah di Stok', 'error')->position('center-end');
                        return redirect('/transaksi/detail/' . $request->kode_transaksi);
                    } else if ($proses >= 0) {
                        $count++;
                        if ($htgBrg == $count) {
                            $jmlStok = true;
                        }
                    }
                }
            }
            if ($jmlStok) {
                foreach ($detailPro as $item) {
                    $stok = Stok::where('kode_barang', '=', $item->kode_barang)->select('kode_barang', 'jumlah')->get();
                    $detail = Detail::where('kode_barang', '=', $item->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get();
                    $jmlBrg = $detail[0]->jumlah;
                    $jmlStok = $stok[0]->jumlah;
                    $proses = $jmlStok - $jmlBrg;
                    Stok::where('kode_agen', $item->kode_agen)->where('kode_barang', $item->kode_barang)->update(['jumlah' => $proses]);
                }
                Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->update(['valid' => 1]);
            }
        } else if ($trJenis->jenis == "Retur") { //kode barang kosong

            // error handling
            // barang a barang b
            // jika barang a kosong barang b cancel update b
            // error handling
            $cekError = false;
            $count = 0;
            $tbDetail = Detail::where('kode_transaksi', $request->kode_transaksi);
            $htgBrg = $tbDetail->count();

            foreach ($detailPro as $item) {
                $cekStok = Stok::where('kode_barang', '=', $item->kode_barang)->exists();
                $errorStok = Parfum::where('kode_barang', $item->kode_barang)->select('kode_barang', 'nama_barang')->get();

                if (is_null($tbStok) || !$cekStok) { //tb stok kosong    //pasti onok bug e
                    toast('Barang "' . $errorStok[0]->nama_barang . '" Belum ada di Stok', 'error')->position('center-end');
                    return redirect('/transaksi/detail/' . $request->kode_transaksi);
                } else if ($cekStok) {
                    $count++;
                    if ($htgBrg == $count) {
                        $cekError = true;
                    }
                }
            }
            $jmlStok = false;
            $count = 0;
            $tbDetail = Detail::where('kode_transaksi', $request->kode_transaksi);
            $htgBrg = $tbDetail->count();
            if ($cekError) {
                foreach ($detailPro as $item) {

                    $stok = Stok::where('kode_barang', '=', $item->kode_barang)->select('kode_barang', 'jumlah')->get();
                    $detail = Detail::where('kode_barang', '=', $item->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get();
                    $jmlBrg = $detail[0]->jumlah;
                    $jmlStok = $stok[0]->jumlah;

                    $proses = $jmlStok - $jmlBrg;
                    $cekStok = Stok::where('kode_barang', '=', $item->kode_barang)->exists();
                    $errorStok = Parfum::where('kode_barang', $item->kode_barang)->select('kode_barang', 'nama_barang')->get();

                    if ($proses < 0) { //tb stok kosong    //pasti onok bug e
                        toast('Jumlah Barang "' . $errorStok[0]->nama_barang . '" yang disetorkan melebihi Jumlah di Stok', 'error')->position('center-end');
                        return redirect('/transaksi/detail/' . $request->kode_transaksi);
                    } else if ($proses >= 0) {
                        $count++;
                        if ($htgBrg == $count) {
                            $jmlStok = true;
                        }
                    }
                }
            }
            if ($jmlStok) {
                foreach ($detailPro as $item) {
                    $stok = Stok::where('kode_barang', '=', $item->kode_barang)->select('kode_barang', 'jumlah')->get();
                    $detail = Detail::where('kode_barang', '=', $item->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get();
                    $jmlBrg = $detail[0]->jumlah;
                    $jmlStok = $stok[0]->jumlah;
                    $proses = $jmlStok - $jmlBrg;
                    Stok::where('kode_agen', $item->kode_agen)->where('kode_barang', $item->kode_barang)->update(['jumlah' => $proses]);
                }
                Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->update(['valid' => 1]);

            }

        }
        return redirect('/transaksi/')->with('success', 'Data berhasil ditambahkan');
    }
}
}
