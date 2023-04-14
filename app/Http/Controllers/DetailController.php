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
        $detailPro = Detail::join('tb_transaksi', 'tb_transaksi.kode_transaksi', '=', 'tb_transaksi_detail.kode_transaksi')
            ->Where('tb_transaksi_detail.kode_transaksi', $request->kode_transaksi)
            ->select('tb_transaksi.kode_agen', 'tb_transaksi.jenis', 'tb_transaksi_detail.kode_barang', 'tb_transaksi_detail.jumlah')->get();
        $sto = Stok::select('kode_agen', 'kode_barang', 'jumlah')->get();
        // dd($detailPro);
        // dd($detailPro[0]);
        $stok = Stok::where('kode_agen', '=', $detailPro[0]->kode_agen)->select('kode_agen', 'kode_barang', 'jumlah')->get()->first();
        $kodeAgen = $stok->kode_agen;
        $kodeBrg = $stok->kode_barang;
        $jmlStok = $stok->jumlah;
        $trAgen = Transaksi::where('kode_agen', '=', $detailPro[0]->kode_agen)->select('kode_agen')->get()->first();
        $trDtBrg = Detail::where('kode_barang', '=', $detailPro[0]->kode_barang)->select('kode_barang')->get()->first();
        $jmlBrg = Detail::where('kode_barang', '=', $detailPro[0]->kode_barang)->select('jumlah')->get()->first();
        // $tol = Detail::join('tb_transaksi', 'tb_transaksi.kode_transaksi', '=', 'tb_transaksi_detail.kode_transaksi')
        //     ->join('tb_stok', 'tb_transaksi_detail.kode_barang', '=', 'tb_stok.kode_barang')
        //     ->join('tb_transaksi', 'tb_transaksi.kode_agen', '=', 'tb_stok.kode_agen')
        //     ->where('tb_transaksi.kode_transaksi', $request->kode_transaksi)
        //     ->select('tb_stok.kode_barang', 'tb_transaksi.nama_agen', 'tb_transaksi_detail.kode_barang')
        //     ->get();
        // dd($trAgen->kode_agen);
        // dd($trAgen->kode_agen);
        // dd($request->all());
        $trJenis = Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->select('jenis')->get()->first();
        if ($trJenis->jenis == "Masuk") {
            if ($trAgen->kode_agen != $kodeAgen || $trDtBrg->kode_barang !== $kodeBrg) {
                dd("New");
                // Stok::create([
                //     'kode_agen' => $detailPro->kode_agen,
                //     'kode_barang' => $detailPro->kode_barang,
                //     'jumlah' => $detailPro->jumlah,
                // ]);
            } else {
                dd($jmlStok + $jmlBrg->jumlah);
                // dd(['jumlah'=>detailPro[0]->jumlah+]);
            }
        }

        // foreach ($detailPro as $ite) {
        //     $at1 = $ite->kode_agen;
        //     $at2 = $ite->kode_barang;
        //     $at3 = $ite->jumlah;
        //     // foreach ($sto as $dum){
        //     // if($dum -> kode_barang = null && $dum -> nama_agen = null ){
        //     Stok::create([
        //         'kode_agen' => $at1,
        //         'kode_barang' => $at2,
        //         'jumlah' => $at3,
        //     ]);
        //     // }
        //     // }

        // }

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
