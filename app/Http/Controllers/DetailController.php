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
        //  dd($war);
        $barang = Parfum::all();

        // $list = Detail::join('tb_parfum','tb_parfum.kode_barang','=','tb_transaksi_detail.kode_barang')
        // ->select('tb_transaksi_detail.*','tb_parfum.nama_barang')
        // ->get();
        $viewDetailbarang = Detail::join('tb_transaksi', 'tb_transaksi.kode_transaksi', '=', 'tb_transaksi_detail.kode_transaksi')
            ->join('tb_parfum', 'tb_transaksi_detail.kode_barang', '=', 'tb_parfum.kode_barang')
            ->join('tb_agen', 'tb_transaksi.kode_agen', '=', 'tb_agen.kode_agen')
            ->where('tb_transaksi.kode_transaksi', $id)
            ->select('tb_transaksi.kode_transaksi', 'tb_parfum.nama_barang', 'tb_agen.nama_agen', 'tb_transaksi_detail.jumlah', 'tb_parfum.kode_barang','tb_parfum.h_beli','tb_transaksi_detail.harga')
            ->get();
        // $idBarang = Detail::join('tb_transaksi', 'tb_transaksi.kode_transaksi', '=', 'tb_transaksi_detail.kode_transaksi')
        //     ->join('tb_parfum', 'tb_transaksi_detail.kode_barang', '=', 'tb_parfum.kode_barang')
        //     ->where('tb_transaksi.kode_transaksi', $id)
        //     ->select('tb_parfum.kode_barang', 'tb_transaksi_detail.kode_barang')
        //     ->get();
        // // dd($tol[0]->nama_barang);
        // $idBarangDetail = Detail::where('kode_transaksi', '=', $id)->select('kode_barang')->get()->first();
        // // dd($barang[0]->kode_barang);

        $agen = Agen::all();
        // dd($agen);
        return view('transaksi/Pusat/transaksi-detail', [
            'transact' => $transact,
            'Nama' => $namaAgen,
            'parfum' => $barang,
            'DataBarang' => $viewDetailbarang,
            'agen' => $agen,

            // 'id' => $idBarang,
            // 'idBarang' => $barang[0]->kode_barang,
            // 'idDetail' => $idBarangDetail,
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
        // dd($hargaPusat);
        

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
        // dd([$detail, $trNum, $id]);
        $detail->delete();
        return redirect('/transaksi/detail/' . $trNum)->with('success', 'Data berhasil dihapus');
    }
    // public function debug()
    // {
    //     $detailPro = Detail::join('tb_transaksi', 'tb_transaksi.kode_transaksi', '=', 'tb_transaksi_detail.kode_transaksi')
    //         ->Where('tb_transaksi_detail.kode_transaksi', "T170523001")
    //         ->select('tb_transaksi.kode_agen', 'tb_transaksi.jenis', 'tb_transaksi_detail.kode_barang', 'tb_transaksi_detail.jumlah')->get();
    //     $colDetail = collect($detailPro);
    //     // dump($collection[]->jumlah);
    //     $tes = Stok::all();
    //     $colTes = collect($tes);
    //     $detail = Detail::all();
    //     $colDetailtb = collect($detail);
    //     // dd($colTes);
    //     // for ($i = 0; $i < count($detailPro); $i++) {
    //     //     $stok = Stok::where('kode_barang', '=', $colDetail[$i]->kode_barang)->get();
    //     //     $colStok = collect([$stok]);
    //     // $stok = Stok::where('kode_barang', '=', $item->kode_barang)->select('kode_barang', 'jumlah')->get();
    //     // $detail = Detail::where('kode_barang', '=', $item->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get();
    //     // }
    //     // dd($colDetailtb[13]->kode_transaksi);
    //     for ($i = 0; $i < count($colDetailtb); $i++) {
    //         if ($colDetailtb[$i]->kode_transaksi == "T170523001") {
    //             $data = collect($colDetailtb[$i]->jumlah);
    //         }
    //     }
    //     dump([$data]);
    //     for ($i = 0; $i < count($detailPro); $i++) {

    //         // $jmlBrg = $detail[0]->jumlah;
    //         // $jmlStok = $stok[0]->jumlah;
    //         // for ($j = 0; $j < count($colTes); $j++) {
    //         //     if ($colTes[$j]->kode_barang == $colDetail[$i]->kode_barang &&
    //         //         $colTes[$j]->kode_agen == $colDetail[$i]->kode_agen
    //         //     ) {
    //         //         $jmlBrg = $colDetailtb[$j]->jumlah;
    //         //         $jmlStok = $colTes[$j]->jumlah;
    //         //         $proses = $jmlStok - $jmlBrg;
    //         //         dump([$colTes[$j]->kode_barang, $proses]);
    //         //     } else {
    //         //         dd('netnot');
    //         //     }
    //         // }
    //     }

    // }

    // public function validProses(Request $request)
    // {
    //     $detailPro = Detail::join('tb_transaksi','tb_transaksi.kode_transaksi','=','tb_transaksi_detail.kode_transaksi')
    //     ->Where('tb_transaksi_detail.kode_transaksi',$request->kode_transaksi)
    //     ->select('tb_transaksi.kode_agen','tb_transaksi.jenis','tb_transaksi_detail.kode_barang','tb_transaksi_detail.jumlah')->get();
    //     $sto = Stok::select('kode_agen','kode_barang','jumlah')->get();
    //     // dd($detailPro);
    //     foreach($detailPro as $ite){
    //         $at1 = $ite->kode_agen;
    //         $at2 = $ite->kode_barang;
    //         $at3 = $ite->jumlah;
    //         $at4 = $ite->jenis;

    //         //masuk
    //         if(!$at4 == 'Setor' && !$at4 =='Retur'){
    //            if(!$sto->kode_agen = value($sto->kode_agen)&& !$sto->kode_barang = value($sto->kode_barang) ){
    //             Stok::create([
    //                 'kode_agen' => $at1,
    //                 'kode_barang' => $at2,
    //                 'jumlah' => '0'
    //             ]);
    //            }
    //         }

    //         // if()
    //     }

    //     return redirect('/transaksi/detail/'.$request->kode_transaksi)->with('success', 'Data berhasil ditambahkan');

    // }

    public function detailmasuk(Request $request)
    {

        $detailPro = Detail::join('tb_transaksi', 'tb_transaksi.kode_transaksi', '=', 'tb_transaksi_detail.kode_transaksi')
            ->Where('tb_transaksi_detail.kode_transaksi', $request->kode_transaksi)
            ->select('tb_transaksi.kode_agen', 'tb_transaksi.jenis', 'tb_transaksi_detail.kode_barang', 'tb_transaksi_detail.jumlah')->get();

        // $stok = Stok::where('kode_barang', '=', $detailPro[0]->kode_barang)->select('kode_barang', 'jumlah')->get()->first();
        $tbStok = Stok::select('kode_agen')->get()->first();
        $storke = $request->setor_ke;
        // dd($storke);
        $tbStokAgen = Stok::where('kode_agen', '=', $request->setor_ke)->get()->first();
        // dd($tbStokAgen);
        $trJenis = Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->select('jenis')->get()->first();

        // dd(is_null($tbStok));
        if ($trJenis->jenis == "Masuk") {
            foreach ($detailPro as $item) {

                $cekStok = Stok::where('kode_barang', '=', $item->kode_barang)->exists();
                $stok = Stok::where('kode_barang', '=', $item->kode_barang)->select('kode_barang', 'jumlah')->get()->first();

                if (is_null($tbStok) || !$cekStok) { //tb stok kosong    //pasti onok bug e
                    // dump([$item->kode_barang]);
                    // echo ("tes");
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
                    // dd([$proses, $jmlBrg->jumlah, $jmlStok]); //Tambah relasi T stok ke Detail
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
                        // dump($count);
                    }
                    // dump([$count, $htgBrg]);

                }

            }
            // dd($cekError);
            $jmlStok = false;
            $count = 0;
            $tbDetail = Detail::where('kode_transaksi', $request->kode_transaksi);
            $htgBrg = $tbDetail->count();
            if ($cekError) {
                // dump('ntoh');
                foreach ($detailPro as $item) {

                    $stok = Stok::where('kode_barang', '=', $item->kode_barang)->select('kode_barang', 'jumlah')->get();
                    $detail = Detail::where('kode_barang', '=', $item->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get();
                    $jmlBrg = $detail[0]->jumlah;
                    $jmlStok = $stok[0]->jumlah;
                    // dd($request->setor_ke);

                    // dd($tes[0]->kode_barang);
                    // dd([$request->kode_transaksi, $trDtBrg, $kodeBrg])
                    $proses = $jmlStok - $jmlBrg;
                    // dump($proses, $item->kode_barang);
<<<<<<< HEAD
                    $cekStok = Stok::where('kode_barang', '=', $item->kode_barang)->exists();
                    $errorStok = Parfum::where('kode_barang', $item->kode_barang)->select('kode_barang', 'nama_barang')->get();

                    if ($proses < 0) { //tb stok kosong    //pasti onok bug e
                        // dd($cekStok);
                        toast('Jumlah Barang "' . $errorStok[0]->nama_barang . '" yang disetorkan melebihi Jumlah di Stok', 'error')->position('center-end');
                        // dump($count);
                        return redirect('/transaksi/detail/' . $request->kode_transaksi);
                    } else if ($proses >= 0) {
                        $count++;
                        if ($htgBrg == $count) {
                            $jmlStok = true;
                            // dump($count);
                        }
                        // dump([$count, $htgBrg]);
                    }
=======

                    $errorStok = Parfum::where('kode_barang', $item->kode_barang)->select('kode_barang', 'nama_barang')->get();

                    if ($proses < 0) { //tb stok kosong    //pasti onok bug e
                        // dd($cekStok);
                        toast('Jumlah Barang "' . $errorStok[0]->nama_barang . '" yang disetorkan melebihi Jumlah di Stok', 'error')->position('center-end');
                        // dump($count);
                        return redirect('/transaksi/detail/' . $request->kode_transaksi);
                    } else if ($proses >= 0) {
                        $count++;
                        if ($htgBrg == $count) {
                            $jmlStok = true;
                            // dump($count);
                        }
                        // dump([$count, $htgBrg]);

                    }

>>>>>>> 4248a931b7669935a9d6a8a1f8b49068bdc4db9f
                }
            }
            if ($jmlStok) {
                foreach ($detailPro as $item) {
                    $stok = Stok::where('kode_barang', '=', $item->kode_barang)->select('kode_barang', 'jumlah')->get();
                    $detail = Detail::where('kode_barang', '=', $item->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get();
                    $jmlBrg = $detail[0]->jumlah;
                    $jmlStok = $stok[0]->jumlah;
                    $proses = $jmlStok - $jmlBrg;
                    // dump($proses, $item->kode_barang);
                    Stok::where('kode_agen', $item->kode_agen)->where('kode_barang', $item->kode_barang)->update(['jumlah' => $proses]);
                }
                Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->update(['valid' => 1]);
<<<<<<< HEAD
            }
=======

            }

>>>>>>> 4248a931b7669935a9d6a8a1f8b49068bdc4db9f
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
                    // dd($cekStok);
                    toast('Barang "' . $errorStok[0]->nama_barang . '" Belum ada di Stok', 'error')->position('center-end');
                    return redirect('/transaksi/detail/' . $request->kode_transaksi);
                } else if ($cekStok) {
                    $count++;
                    if ($htgBrg == $count) {
                        $cekError = true;
                        // dump($count);
                    }
                    // dump([$count, $htgBrg]);

                }

            }
            // dd($cekError);
            $jmlStok = false;
            $count = 0;
<<<<<<< HEAD
            $tbDetail = Detail::where('kode_transaksi', $request->kode_transaksi);
            $htgBrg = $tbDetail->count();
=======

>>>>>>> 4248a931b7669935a9d6a8a1f8b49068bdc4db9f
            if ($cekError) {
                // dump('ntoh');
                foreach ($detailPro as $item) {

                    $stok = Stok::where('kode_barang', '=', $item->kode_barang)->select('kode_barang', 'jumlah')->get();
                    $detail = Detail::where('kode_barang', '=', $item->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get();
                    $jmlBrg = $detail[0]->jumlah;
                    $jmlStok = $stok[0]->jumlah;
                    // dd($request->setor_ke);

                    // dd($tes[0]->kode_barang);
                    // dd([$request->kode_transaksi, $trDtBrg, $kodeBrg])
                    $proses = $jmlStok - $jmlBrg;
                    // dump($proses, $item->kode_barang);
<<<<<<< HEAD
                    $cekStok = Stok::where('kode_barang', '=', $item->kode_barang)->exists();
=======

>>>>>>> 4248a931b7669935a9d6a8a1f8b49068bdc4db9f
                    $errorStok = Parfum::where('kode_barang', $item->kode_barang)->select('kode_barang', 'nama_barang')->get();

                    if ($proses < 0) { //tb stok kosong    //pasti onok bug e
                        // dd($cekStok);
<<<<<<< HEAD
                        toast('Jumlah Barang "' . $errorStok[0]->nama_barang . '" yang disetorkan melebihi Jumlah di Stok', 'error')->position('center-end');
=======
                        toast('Jumlah Barang "' . $errorStok[0]->nama_barang . '" yang direturkan melebihi Jumlah di Stok', 'error')->position('center-end');
>>>>>>> 4248a931b7669935a9d6a8a1f8b49068bdc4db9f
                        // dump($count);
                        return redirect('/transaksi/detail/' . $request->kode_transaksi);
                    } else if ($proses >= 0) {
                        $count++;
                        if ($htgBrg == $count) {
                            $jmlStok = true;
                            // dump($count);
                        }
                        // dump([$count, $htgBrg]);

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
<<<<<<< HEAD
                    dump($proses, $item->kode_barang);
=======
                    // dump($proses, $item->kode_barang);
>>>>>>> 4248a931b7669935a9d6a8a1f8b49068bdc4db9f
                    Stok::where('kode_agen', $item->kode_agen)->where('kode_barang', $item->kode_barang)->update(['jumlah' => $proses]);
                }
                Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->update(['valid' => 1]);

            }

        }
        return redirect('/transaksi/')->with('success', 'Data berhasil ditambahkan');
    }

}
