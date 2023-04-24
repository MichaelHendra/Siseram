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

        $war = Transaksi::find($id)
            ->join('tb_agen', 'tb_agen.kode_agen', '=', 'tb_transaksi.kode_agen')
            ->where('tb_transaksi.kode_transaksi', $id)
            ->get('tb_agen.nama_agen');
        
        $war69 = Transaksi::find($id)
        ->join('tb_agen', 'tb_agen.kode_agen', '=', 'tb_transaksi.kode_agen')
        ->where('tb_transaksi.kode_transaksi', $id)
        ->get('tb_agen.kode_agen');
        //   dd($war69);
        $barang = Parfum::all();

        // $list = Detail::join('tb_parfum','tb_parfum.kode_barang','=','tb_transaksi_detail.kode_barang')
        // ->select('tb_transaksi_detail.*','tb_parfum.nama_barang')
        // ->get();
        $tol = Detail::join('tb_transaksi', 'tb_transaksi.kode_transaksi', '=', 'tb_transaksi_detail.kode_transaksi')
            ->join('tb_parfum', 'tb_transaksi_detail.kode_barang', '=', 'tb_parfum.kode_barang')
            ->join('tb_agen', 'tb_transaksi.kode_agen', '=', 'tb_agen.kode_agen')
            ->where('tb_transaksi.kode_transaksi', $id)
            ->select('tb_transaksi.kode_transaksi', 'tb_parfum.nama_barang', 'tb_agen.nama_agen', 'tb_transaksi_detail.jumlah', 'tb_parfum.kode_barang')
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
            'ngeng' => $transact,
            'waro' => $war,
            'par' => $barang,
            'det' => $tol,
            'agen' => $agen,
            'waro69' => $war69,
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

        Detail::create([
            'kode_transaksi' => $request->kode_transaksi,
            'kode_barang' => $request->kode_barang,
            'jumlah' => $request->jumlah,
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

    public function detailAgenMasuk(Request $request)
    {
        $nyoba = Detail::select('kode_barang')->where('kode_transaksi', $request->kode_transaksi)->get();

        $detailPro = Detail::join('tb_transaksi', 'tb_transaksi.kode_transaksi', '=', 'tb_transaksi_detail.kode_transaksi')
            ->Where('tb_transaksi_detail.kode_transaksi', $request->kode_transaksi)
            ->select('tb_transaksi.kode_agen', 'tb_transaksi.jenis', 'tb_transaksi_detail.kode_barang', 'tb_transaksi_detail.jumlah')->get();
        
        $stok = Stok::where('kode_barang', '=', $detailPro[0]->kode_barang)->select('kode_barang', 'jumlah')->get()->first();
        $tbStok = Stok::select('kode_agen')->get()->first();
        // dd($tbStok);
        $storke = $request->setor_ke;
        // dd($storke);
        // dd($request->setor_ke);
        $tbStokAgen = Stok::where('kode_agen','=',$request->setor_ke)->get()->first();
        // dd($tbStokAgen);
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
                

                if (is_null($tbStok) || !$cekStok) { //tb stok kosong    //pasti onok bug e
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
            if ($cekError) {
                // dump('ntoh');
                foreach ($detailPro as $item) {
                    

                    $stok = Stok::where('kode_barang', '=', $item->kode_barang)->select('kode_barang', 'jumlah')->get();
                    $detail = Detail::where('kode_barang', '=', $item->kode_barang)->where('kode_transaksi', $request->kode_transaksi)->select('jumlah')->get();
                    // dd($stokAgen);
                    $jmlBrg = $detail[0]->jumlah;
                    $jmlStok = $stok[0]->jumlah;
                   
                    // dd($tbStokAgen);
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

                    Stok::where('kode_agen', $tbStok->kode_agen)->where('kode_barang', $item->kode_barang)->update(['jumlah' => $proses]);
                    Transaksi::where('kode_transaksi', '=', $request->kode_transaksi)->update(['valid' => 1]);
                }
            }

        
        }
        return redirect('/transaksi/agen/')->with('success', 'Data berhasil ditambahkan');
    }
}
