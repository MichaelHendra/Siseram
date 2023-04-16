<?php

namespace App\Http\Controllers;

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

        $war = Transaksi::find($id)
            ->join('tb_agen', 'tb_agen.kode_agen', '=', 'tb_transaksi.kode_agen')
            ->where('tb_transaksi.kode_transaksi', $id)
            ->get('tb_agen.nama_agen');
        //  dd($war);
        $barang = Parfum::all();

        // $list = Detail::join('tb_parfum','tb_parfum.kode_barang','=','tb_transaksi_detail.kode_barang')
        // ->select('tb_transaksi_detail.*','tb_parfum.nama_barang')
        // ->get();
        $tol = Detail::join('tb_transaksi', 'tb_transaksi.kode_transaksi', '=', 'tb_transaksi_detail.kode_transaksi')
            ->join('tb_parfum', 'tb_transaksi_detail.kode_barang', '=', 'tb_parfum.kode_barang')
            ->join('tb_agen', 'tb_transaksi.kode_agen', '=', 'tb_agen.kode_agen')
            ->where('tb_transaksi.kode_transaksi', $id)
            ->select('tb_parfum.nama_barang', 'tb_agen.nama_agen', 'tb_transaksi_detail.jumlah')
            ->get();
        $idBarang = Detail::join('tb_transaksi', 'tb_transaksi.kode_transaksi', '=', 'tb_transaksi_detail.kode_transaksi')
            ->join('tb_parfum', 'tb_transaksi_detail.kode_barang', '=', 'tb_parfum.kode_barang')
            ->where('tb_transaksi.kode_transaksi', $id)
            ->select('tb_parfum.kode_barang', 'tb_transaksi_detail.kode_barang')
            ->get();
        // dd($tol[0]->nama_barang);
        $idBarangDetail = Detail::where('kode_transaksi', '=', $id)->select('kode_barang')->get()->first();
        // dd($barang[0]->kode_barang);
        return view('transaksi/Pusat/transaksi-detail', [
            'ngeng' => $transact,
            'waro' => $war,
            'par' => $barang,
            'det' => $tol,
            'id' => $idBarang,
            'idBarang' => $barang[0]->kode_barang,
            'idDetail' => $idBarangDetail,
        ]);
    }

    public function detailProses(Request $request)
    { //detail/tambah
        $this->validate($request, [
            'kode_transaksi' => 'required',
            'kode_barang' => 'required',
            'jumlah' => 'required',
        ]);

        Detail::create([
            'kode_transaksi' => $request->kode_transaksi,
            'kode_barang' => $request->kode_barang,
            'jumlah' => $request->jumlah,
        ]);
        return redirect('/transaksi/detail/' . $request->kode_transaksi)->with('success', 'Data berhasil ditambahkan');

    }

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

        function tambahData($kode_transaksi)
        {
            // dd($kode_transaksi);
            $detailPro = Detail::join('tb_transaksi', 'tb_transaksi.kode_transaksi', '=', 'tb_transaksi_detail.kode_transaksi')
                ->Where('tb_transaksi_detail.kode_transaksi', $kode_transaksi)
                ->select('tb_transaksi.kode_agen', 'tb_transaksi.jenis', 'tb_transaksi_detail.kode_barang', 'tb_transaksi_detail.jumlah')->get();
            Stok::create([
                'kode_agen' => $detailPro[0]->kode_agen,
                'kode_barang' => $detailPro[0]->kode_barang,
                'jumlah' => $detailPro[0]->jumlah,
            ]);
        }
        $detailPro = Detail::join('tb_transaksi', 'tb_transaksi.kode_transaksi', '=', 'tb_transaksi_detail.kode_transaksi')
            ->Where('tb_transaksi_detail.kode_transaksi', $request->kode_transaksi)
            ->select('tb_transaksi.kode_agen', 'tb_transaksi.jenis', 'tb_transaksi_detail.kode_barang', 'tb_transaksi_detail.jumlah')->get();
        $cekStok = Stok::where('kode_barang', '=', $detailPro[0]->kode_barang)->exists();
        $stok = Stok::where('kode_barang', '=', $detailPro[0]->kode_barang)->select('kode_barang', 'jumlah')->get()->first();
        $tbStok = Stok::select('kode_agen')->get()->first();
        $trJenis = Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->select('jenis')->get()->first();
        $errorStok = Parfum::where('kode_barang', $detailPro[0]->kode_barang)->select('nama_barang')->get()->first();
        // dd(is_null($tbStok));
        if ($trJenis->jenis == "Masuk") {
            if (is_null($tbStok) || !$cekStok) { //tb stok kosong    //pasti onok bug e

                tambahData($request->kode_transaksi); //stok
                Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->update(['valid' => 1]);
            }
            //kode barang kosong
            else {
                $coba = Detail::join('tb_transaksi', 'tb_transaksi_detail.kode_transaksi', '=', 'tb_transaksi.kode_transaksi')
                    ->where('tb_transaksi.kode_transaksi', $request->kode_transaksi)
                    ->select('tb_transaksi.kode_agen', 'tb_transaksi_detail.kode_barang')
                    ->get();
                $tes = Stok::join('tb_transaksi_detail', 'tb_transaksi_detail.kode_barang', '=', 'tb_stok.kode_barang')
                // ->join('tb_transaksi', 'tb_transaksi.kode_agen', '=', 'tb_stok.kode_agen')
                    ->join('tb_transaksi', 'tb_transaksi_detail.kode_transaksi', '=', 'tb_transaksi.kode_transaksi')
                    ->where('tb_transaksi.kode_transaksi', $request->kode_transaksi)
                    ->select('tb_transaksi.kode_agen', 'tb_transaksi_detail.kode_barang', 'tb_transaksi.kode_transaksi')
                    ->first()
                    ->get();
                $jmlBrg = Detail::where('kode_barang', '=', $detailPro[0]->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get()->first();
                $kodeBrg = $tes[0]->kode_barang;
                $jmlStok = $stok->jumlah;
                $trDtBrg = $coba[0]->kode_barang;
                // dd($tes[0]->kode_barang);
                // dd([$request->kode_transaksi, $trDtBrg, $kodeBrg]);
                if ($trDtBrg == $kodeBrg) {

                    $proses = $jmlStok + $jmlBrg->jumlah;
                    // dd([$proses, $jmlBrg->jumlah, $jmlStok]); //Tambah relasi T stok ke Detail
                    Stok::where('kode_agen', $detailPro[0]->kode_agen)->where('kode_barang', $detailPro[0]->kode_barang)->update(['jumlah' => $proses]);
                    Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->update(['valid' => 1]);
                }
            }
        } else if ($trJenis->jenis == "Setor") { //kode barang kosong

            if (is_null($tbStok) || !$cekStok) { //tb stok kosong    //pasti onok bug e

                return view('transaksi.Pusat.transaksi-error', [
                    'error' => $errorStok->nama_barang,
                    'id' => $request->kode_transaksi]);
            } else {
                $coba = Detail::join('tb_transaksi', 'tb_transaksi_detail.kode_transaksi', '=', 'tb_transaksi.kode_transaksi')
                    ->where('tb_transaksi.kode_transaksi', $request->kode_transaksi)
                    ->select('tb_transaksi.kode_agen', 'tb_transaksi_detail.kode_barang')
                    ->get();
                $tes = Stok::join('tb_transaksi_detail', 'tb_transaksi_detail.kode_barang', '=', 'tb_stok.kode_barang')
                // ->join('tb_transaksi', 'tb_transaksi.kode_agen', '=', 'tb_stok.kode_agen')
                    ->join('tb_transaksi', 'tb_transaksi_detail.kode_transaksi', '=', 'tb_transaksi.kode_transaksi')
                    ->where('tb_transaksi.kode_transaksi', $request->kode_transaksi)
                    ->select('tb_transaksi.kode_agen', 'tb_transaksi_detail.kode_barang', 'tb_transaksi.kode_transaksi')
                    ->first()
                    ->get();
                $jmlBrg = Detail::where('kode_barang', '=', $detailPro[0]->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get()->first();
                $kodeBrg = $tes[0]->kode_barang;
                $jmlStok = $stok->jumlah;
                $trDtBrg = $coba[0]->kode_barang;
                // dd($tes[0]->kode_barang);
                // dd([$request->kode_transaksi, $trDtBrg, $kodeBrg]);
                if ($trDtBrg == $kodeBrg) {

                    $proses = $jmlStok - $jmlBrg->jumlah;
                    // dd([$proses, $jmlBrg->jumlah, $jmlStok]); //Tambah relasi T stok ke Detail
                    Stok::where('kode_agen', $detailPro[0]->kode_agen)->where('kode_barang', $detailPro[0]->kode_barang)->update(['jumlah' => $proses]);
                    Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->update(['valid' => 1]);

                }
            }
        } else if ($trJenis->jenis == "Retur") { //kode barang kosong
            // dd($cekStok);
            if (is_null($tbStok)) { //tb stok kosong    //pasti onok bug e

                return view('transaksi.Pusat.transaksi-error', [
                    'error' => $errorStok->nama_barang,
                    'id' => $request->kode_transaksi]);
            }
            if (!$cekStok) {
                // dd($errorStok->nama_barang);
                return view('transaksi.Pusat.transaksi-error', [
                    'error' => $errorStok->nama_barang,
                    'id' => $request->kode_transaksi]);
            } else {
                $coba = Detail::join('tb_transaksi', 'tb_transaksi_detail.kode_transaksi', '=', 'tb_transaksi.kode_transaksi')
                    ->where('tb_transaksi.kode_transaksi', $request->kode_transaksi)
                    ->select('tb_transaksi.kode_agen', 'tb_transaksi_detail.kode_barang')
                    ->get();
                $tes = Stok::join('tb_transaksi_detail', 'tb_transaksi_detail.kode_barang', '=', 'tb_stok.kode_barang')
                // ->join('tb_transaksi', 'tb_transaksi.kode_agen', '=', 'tb_stok.kode_agen')
                    ->join('tb_transaksi', 'tb_transaksi_detail.kode_transaksi', '=', 'tb_transaksi.kode_transaksi')
                    ->where('tb_transaksi.kode_transaksi', $request->kode_transaksi)
                    ->select('tb_transaksi.kode_agen', 'tb_transaksi_detail.kode_barang', 'tb_transaksi.kode_transaksi')
                    ->first()
                    ->get();
                $jmlBrg = Detail::where('kode_barang', '=', $detailPro[0]->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get()->first();
                $kodeBrg = $tes[0]->kode_barang;
                $jmlStok = $stok->jumlah;
                $trDtBrg = $coba[0]->kode_barang;
                // dd([$request->kode_transaksi, $trDtBrg, $kodeBrg]);
                if ($trDtBrg == $kodeBrg) {
                    // dd([$trDtBrg, $kodeBrg]);
                    $proses = $jmlStok - $jmlBrg->jumlah;
                    // dd([$proses, $jmlBrg->jumlah, $jmlStok]); //Tambah relasi T stok ke Detail
                    Stok::where('kode_agen', $detailPro[0]->kode_agen)->where('kode_barang', $detailPro[0]->kode_barang)->update(['jumlah' => $proses]);
                    Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->update(['valid' => 1]);

                }
            }
        }
        return redirect('/transaksi/')->with('success', 'Data berhasil ditambahkan');
    }
    public function detailsetor(Request $request)
    {
        # code...
    }
    public function detailretur(Request $request)
    {
        # code...
    }

}
