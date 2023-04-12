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
        ->join('tb_agen','tb_agen.kode_agen','=','tb_transaksi.kode_agen')
        ->where('tb_transaksi.kode_transaksi',$id)
        ->get('tb_agen.nama_agen');
        //  dd($war);
        $barang = Parfum::all();

        // $list = Detail::join('tb_parfum','tb_parfum.kode_barang','=','tb_transaksi_detail.kode_barang')
        // ->select('tb_transaksi_detail.*','tb_parfum.nama_barang')
        // ->get();
        $tol = Detail::join('tb_transaksi','tb_transaksi.kode_transaksi','=','tb_transaksi_detail.kode_transaksi')
        ->join('tb_parfum','tb_transaksi_detail.kode_barang','=','tb_parfum.kode_barang')
        ->join('tb_agen','tb_transaksi.kode_agen','=','tb_agen.kode_agen')
        ->where('tb_transaksi.kode_transaksi',$id)
        ->select('tb_parfum.nama_barang','tb_agen.nama_agen','tb_transaksi_detail.jumlah')
        ->get();

        return view('transaksi/Pusat/transaksi-detail',[
        'ngeng' => $transact,
        'waro'=> $war, 
        'par' => $barang,
        'det' => $tol,
        ]);
    }

    public function detailProses(Request $request)
    {
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
        return redirect('/transaksi/detail/'.$request->kode_transaksi)->with('success', 'Data berhasil ditambahkan');

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
        $detailPro = Detail::join('tb_transaksi','tb_transaksi.kode_transaksi','=','tb_transaksi_detail.kode_transaksi')
        ->Where('tb_transaksi_detail.kode_transaksi',$request->kode_transaksi)
        ->select('tb_transaksi.kode_agen','tb_transaksi.jenis','tb_transaksi_detail.kode_barang','tb_transaksi_detail.jumlah')->get();
        $sto = Stok::select('kode_agen','kode_barang','jumlah')->get();
        // dd($detailPro);
        
            foreach($detailPro as $ite){
                $at1 = $ite->kode_agen;
                $at2 = $ite->kode_barang;
                $at3 = $ite->jumlah;
            // foreach ($sto as $dum){
                // if($dum -> kode_barang = null && $dum -> nama_agen = null ){
                    Stok::create([
                        'kode_agen' => $at1,
                        'kode_barang' => $at2,
                        'jumlah' => $at3, 
                    ]);
                // }
            // }
                

          
        }
        
        
        return redirect('/transaksi/detail/'.$request->kode_transaksi)->with('success', 'Data berhasil ditambahkan');
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
