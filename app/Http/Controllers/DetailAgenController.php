<?php

namespace App\Http\Controllers;
use App\Models\Agen;
use App\Models\Detail;
use App\Models\Parfum;
use App\Models\Stok;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DetailAgenController extends Controller
{
    public function detailTapil(string $id)
    {

        $transact = Transaksi::find($id);

        $namaAgen = Transaksi::find($id)
            ->join('tb_agen', 'tb_agen.kode_agen', '=', 'tb_transaksi.kode_agen')
            ->where('tb_transaksi.kode_transaksi', $id)
            ->get('tb_agen.nama_agen');
        
        $kodeAgen = Transaksi::find($id)
        ->join('tb_agen', 'tb_agen.kode_agen', '=', 'tb_transaksi.kode_agen')
        ->where('tb_transaksi.kode_transaksi', $id)
        ->get('tb_agen.kode_agen');
        //   dd($war69);
        $barang = Parfum::all();
        
        // $list = Detail::join('tb_parfum','tb_parfum.kode_barang','=','tb_transaksi_detail.kode_barang')
        // ->select('tb_transaksi_detail.*','tb_parfum.nama_barang')
        // ->get();

        $Pusat = Agen::where('status','=','1')->get();
        $viewDetailbarang = Detail::join('tb_transaksi', 'tb_transaksi.kode_transaksi', '=', 'tb_transaksi_detail.kode_transaksi')
        ->join('tb_parfum', 'tb_transaksi_detail.kode_barang', '=', 'tb_parfum.kode_barang')
        ->join('tb_agen', 'tb_transaksi.kode_agen', '=', 'tb_agen.kode_agen')
        ->where('tb_transaksi.kode_transaksi', $id)
        ->select('tb_transaksi.kode_transaksi', 'tb_parfum.nama_barang', 'tb_agen.nama_agen', 'tb_transaksi_detail.jumlah', 'tb_parfum.kode_barang','tb_parfum.h_agen','tb_transaksi_detail.harga')
        ->get();
        // $idBarang = Detail::join('tb_transaksi', 'tb_transaksi.kode_transaksi', '=', 'tb_transaksi_detail.kode_transaksi')
        //     ->join('tb_parfum', 'tb_transaksi_detail.kode_barang', '=', 'tb_parfum.kode_barang')
        //     ->where('tb_transaksi.kode_transaksi', $id)
        //     ->select('tb_parfum.kode_barang', 'tb_transaksi_detail.kode_barang')
        //     ->get();
        // // dd($tol[0]->nama_barang);
        // $idBarangDetail = Detail::where('kode_transaksi', '=', $id)->select('kode_barang')->get()->first();
        // // dd($barang[0]->kode_barang);

        $agen = Agen::Where('status','=','0')->get();
        // dd($agen);
        return view('transaksi/agen/transaksi-detail', [
            'transact' => $transact,
            'Nama' => $namaAgen,
            'parfum' => $barang,
            'DataBarang' => $viewDetailbarang,
            'agen' => $agen,
            'kodeAgen' => $kodeAgen,
            'pusat' => $Pusat,
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

        $hargaParfum = Parfum::where('kode_barang','=',$request->kode_barang)->select('h_agen')->get()->first();
        $jumlahParfum = $request->jumlah;
        $hargaAgen = $jumlahParfum * $hargaParfum->h_agen;
        // dd($hargaPusat);
        

        Detail::create([
            'kode_transaksi' => $request->kode_transaksi,
            'kode_barang' => $request->kode_barang,
            'jumlah' => $request->jumlah,
            'harga' => $hargaAgen,
        ]);
        return redirect('/transaksi/agen/detail/' . $request->kode_transaksi)->with('success', 'Data berhasil ditambahkan');

    }
    public function detailDelete(string $trNum, string $id)
    {
        $detail = Detail::where('kode_transaksi', $trNum)->where('kode_barang', $id);
        // dd([$detail, $trNum, $id]);
        $detail->delete();
        return redirect('/transaksi/agen/detail/' . $trNum)->with('success', 'Data berhasil dihapus');
    }




    public function detailAgenMasuk(Request $request) // fungsi proses barang untuk agen 
    {
        $cekDetail = Detail::where('kode_transaksi', $request->kode_transaksi)->get();
        if($cekDetail->isEmpty()){
            toast('Mohon Untuk Mengisi Barang Terlebih Dahulu', 'error')->position('center-end');
            return redirect('/transaksi/agen/detail/' . $request->kode_transaksi);
        }else{
        $detailPro = Detail::join('tb_transaksi', 'tb_transaksi.kode_transaksi', '=', 'tb_transaksi_detail.kode_transaksi')
            ->Where('tb_transaksi_detail.kode_transaksi', $request->kode_transaksi)
            ->select('tb_transaksi.kode_agen', 'tb_transaksi.jenis', 'tb_transaksi_detail.kode_barang', 'tb_transaksi_detail.jumlah')->get();
        $stok = Stok::where('kode_barang', '=', $detailPro[0]->kode_barang)->select('kode_barang', 'jumlah')->get()->first();
        $tbStok = Stok::where('kode_agen','=','PU001')->get();
        $tbStokAgen = Stok::where('kode_agen','=',$request->setor_ke)->get(); 
        //dd($tbStokAgen);
        $trJenis = Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->select('jenis')->get()->first();
        

        if ($trJenis->jenis == "Masuk") { //kode barang kosong

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
                

                if (is_null($tbStok) || !$cekStok) { //tb stok kosong buat Pusat    //pasti onok bug e
                    // dd($cekStok);
                    toast('Barang "' . $errorStok[0]->nama_barang . '" Belum ada di Stok Pusat', 'error')->position('center-end');
                    return redirect('/transaksi/agen/detail/' . $request->kode_transaksi);
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
                foreach ($detailPro as $item) { // buat nambah barang agen & barang berkurang buat pusat
                    

                    $stok = Stok::where('kode_barang', '=', $item->kode_barang)->select('kode_barang', 'jumlah')->get();
                    $detail = Detail::where('kode_barang', '=', $item->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get();

                    $jmlBrg = $detail[0]->jumlah;
                    $jmlStok = $stok[0]->jumlah;
                    $proses = $jmlStok - $jmlBrg;

                    $cekStok = Stok::where('kode_barang', '=', $item->kode_barang)->exists();
                    $errorStok = Parfum::where('kode_barang', $item->kode_barang)->select('kode_barang', 'nama_barang')->get();
                    if ($proses < 0) { //tb stok kosong    //pasti onok bug e
                        // dd($cekStok);
                        toast('Jumlah Barang "' . $errorStok[0]->nama_barang . '" yang disetorkan melebihi Jumlah di Stok Pusat', 'error')->position('center-end');
                        // dump($count);
                        return redirect('/transaksi/agen/detail/' . $request->kode_transaksi);
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
                    if($jmlStok){

                        foreach ($detailPro as $item) { // buat nambah barang agen & barang berkurang buat pusat
                    

                            $stok = Stok::where('kode_barang', '=', $item->kode_barang)->select('kode_barang', 'jumlah')->get();
                            $detail = Detail::where('kode_barang', '=', $item->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get();
                            // dd($stokAgen);
                            $jmlBrg = $detail[0]->jumlah;
                            $jmlStok = $stok[0]->jumlah;
                           
                            $cekStok = Stok::where('kode_barang', '=', $item->kode_barang)->where('kode_agen','=',$item->kode_agen)->exists();
                            if(is_null($tbStokAgen) || !$cekStok){
                                Stok::create([
                                    'kode_agen' => $item->kode_agen,
                                    'kode_barang' => $item->kode_barang,
                                    'jumlah' => $item->jumlah,
                                ]); //stok
                            } else{
        
                                $stokAgen = Stok::where('kode_agen', $request->setor_ke)->where('kode_barang', $item->kode_barang)->select('jumlah')->get();
                                $jmlBrgAgen = $detail[0]->jumlah; 
                                $jmlStokAgen = $stokAgen[0]->jumlah;
            
                                    $prosesAgen = $jmlStokAgen + $jmlBrgAgen;
                                    
                                    // dd([$proses, $jmlBrg->jumlah, $jmlStok]); //Tambah relasi T stok ke Detail
                                    Stok::where('kode_agen', $request->setor_ke)->where('kode_barang', $item->kode_barang)->update(['jumlah' => $prosesAgen]);
                            }
                            // if()
        
                            $proses = $jmlStok - $jmlBrg;
        
                            Stok::where('kode_agen', $request->pusat)->where('kode_barang', $item->kode_barang)->update(['jumlah' => $proses]);
                            Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->update(['valid' => 1]);
                        }
            }


        } else if($trJenis->jenis == "Setor"){
            $cekError = false;
            $count = 0;
            $tbDetail = Detail::where('kode_transaksi', $request->kode_transaksi);
            $htgBrg = $tbDetail->count();
            
            foreach ($detailPro as $item) {
                $cekStok = Stok::where('kode_barang', '=', $item->kode_barang)->exists();
                $errorStok = Parfum::where('kode_barang', $item->kode_barang)->select('kode_barang', 'nama_barang')->get();

                if (is_null($tbStokAgen) || !$cekStok) { //tb stok kosong    //pasti onok bug e
                    // dd($cekStok);
                    toast('Barang "' . $errorStok[0]->nama_barang . '" Belum ada di Stok Agen', 'error')->position('center-end');
                    return redirect('/transaksi/agen/detail/' . $request->kode_transaksi);
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
            $jmlStokAgen = false;
            $count = 0;
            $tbDetail = Detail::where('kode_transaksi', $request->kode_transaksi);
            $htgBrg = $tbDetail->count();
            if ($cekError) {
                // dump('ntoh');
                foreach ($detailPro as $item) {
                    

                    $stokAgen = Stok::where('kode_agen', $request->setor_ke)->where('kode_barang', $item->kode_barang)->select('jumlah')->get();
                    $detail = Detail::where('kode_barang', '=', $item->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get();
                    $jmlBrg = $detail[0]->jumlah;
                    $jmlStok = $stokAgen[0]->jumlah;
                    // dd($request->setor_ke);
                    
                    // dd($tes[0]->kode_barang);
                    // dd([$request->kode_transaksi, $trDtBrg, $kodeBrg])
                    $proses = $jmlStok - $jmlBrg;
                    $cekStok = Stok::where('kode_barang', '=', $item->kode_barang)->exists();
                    $errorStok = Parfum::where('kode_barang', $item->kode_barang)->select('kode_barang', 'nama_barang')->get();

                    if ($proses < 0) { //tb stok kosong    //pasti onok bug e
                        // dd($cekStok);
                        toast('Jumlah Barang "' . $errorStok[0]->nama_barang . '" yang disetorkan melebihi Jumlah di Stok Agen', 'error')->position('center-end');
                        // dump($count);
                        return redirect('/transaksi/agen/detail/' . $request->kode_transaksi);
                    } else if ($proses >= 0) {
                        $count++;
                        if ($htgBrg == $count) {
                            $jmlStokAgen = true;
                            // dump($count);
                        }
                        // dump([$count, $htgBrg]);

                    }
                }
            }
            if($jmlStokAgen){
                foreach($detailPro as $item){
                    $stokAgen = Stok::where('kode_agen', $request->setor_ke)->where('kode_barang', $item->kode_barang)->select('jumlah')->get();
                    $detail = Detail::where('kode_barang', '=', $item->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get();
                    $jmlBrg = $detail[0]->jumlah;
                    $jmlStok = $stokAgen[0]->jumlah;
                    // dd($request->setor_ke);
                    
                    // dd($tes[0]->kode_barang);
                    // dd([$request->kode_transaksi, $trDtBrg, $kodeBrg])
                    $proses = $jmlStok - $jmlBrg;

                    Stok::where('kode_agen', $item->kode_agen)->where('kode_barang', $item->kode_barang)->update(['jumlah' => $proses]);
                    Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->update(['valid' => 1]);
                }
            }

        
        } else if($trJenis->jenis == "Retur"){
            $cekError = false;
            $count = 0;
            $tbDetail = Detail::where('kode_transaksi', $request->kode_transaksi);
            $htgBrg = $tbDetail->count();
            
            foreach ($detailPro as $item) {
                $cekStok = Stok::where('kode_barang', '=', $item->kode_barang)->exists();
                $errorStok = Parfum::where('kode_barang', $item->kode_barang)->select('kode_barang', 'nama_barang')->get();
                

                if (is_null($tbStokAgen) || !$cekStok) { //tb stok kosong buat Pusat    //pasti onok bug e
                    // dd($cekStok);
                    toast('Barang "' . $errorStok[0]->nama_barang . '" Belum ada di Stok Agen', 'error')->position('center-end');
                    return redirect('/transaksi/agen/detail/' . $request->kode_transaksi);
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
            $jmlStokAgen = false;
            $count = 0;
            $tbDetail = Detail::where('kode_transaksi', $request->kode_transaksi);
            $htgBrg = $tbDetail->count();
            if ($cekError) {
                // dump('ntoh');
                foreach ($detailPro as $item) { // buat nambah barang agen & barang berkurang buat pusat
                    

                    $stok = Stok::where('kode_barang', '=', $item->kode_barang)->select('kode_barang', 'jumlah')->get();
                    $detail = Detail::where('kode_barang', '=', $item->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get();
                    $stokAgen = Stok::where('kode_agen', $request->setor_ke)->where('kode_barang', $item->kode_barang)->select('jumlah')->get();
                    // dd($stokAgen);
                    $jmlBrgAgen = $detail[0]->jumlah; 
                    $jmlStokAgen = $stokAgen[0]->jumlah;
                    $prosesAgen = $jmlStokAgen - $jmlBrgAgen;
                    
                    if ($prosesAgen < 0) { //tb stok kosong    //pasti onok bug e
                        // dd($cekStok);
                        toast('Jumlah Barang "' . $errorStok[0]->nama_barang . '" yang disetorkan melebihi Jumlah di Stok Agen', 'error')->position('center-end');
                        // dump($count);
                        return redirect('/transaksi/agen/detail/' . $request->kode_transaksi);
                    } else if ($prosesAgen >= 0) {
                        $count++;
                        if ($htgBrg == $count) {
                            $jmlStokAgen = true;
                            // dump($count);
                        }
                        // dump([$count, $htgBrg]);

                    }
                }
            }
            if($jmlStokAgen){
                
                foreach ($detailPro as $item) { // buat nambah barang agen & barang berkurang buat pusat
                    

                    $stok = Stok::where('kode_barang', '=', $item->kode_barang)->select('kode_barang', 'jumlah')->get();
                    $detail = Detail::where('kode_barang', '=', $item->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get();
                    // dd($stokAgen);
                    $jmlBrg = $detail[0]->jumlah;
                    $jmlStok = $stok[0]->jumlah;
                    
                    $cekStok = Stok::where('kode_barang', '=', $item->kode_barang)->where('kode_agen','=',$item->kode_agen)->exists();
                    if(is_null($tbStok) || !$cekStok){
                        Stok::create([
                            'kode_agen' => $item->kode_agen,
                            'kode_barang' => $item->kode_barang,
                            'jumlah' => $item->jumlah,
                        ]); //stok
                    } else{
                        
                        $proses = $jmlStok + $jmlBrg;
                        Stok::where('kode_agen', $request->pusat)->where('kode_barang', $item->kode_barang)->update(['jumlah' => $proses]);
                        Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->update(['valid' => 1]);
                    }
                    // if()
                    $stokAgen = Stok::where('kode_agen', $request->setor_ke)->where('kode_barang', $item->kode_barang)->select('jumlah')->get();
                    $jmlBrgAgen = $detail[0]->jumlah; 
                    $jmlStokAgen = $stokAgen[0]->jumlah;

                    $prosesAgen = $jmlStokAgen - $jmlBrgAgen;
                        
                        // dd([$proses, $jmlBrg->jumlah, $jmlStok]); //Tambah relasi T stok ke Detail
                    Stok::where('kode_agen', $request->setor_ke)->where('kode_barang', $item->kode_barang)->update(['jumlah' => $prosesAgen]);

                    
                }

            } 
        }
        return redirect('/transaksi/agen/')->with('success', 'Data berhasil ditambahkan');
    }
}
}