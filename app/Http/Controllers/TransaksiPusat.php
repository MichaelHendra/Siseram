<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiExport;
use App\Exports\TransaksiWithDateExport;
use App\Models\Agen;
use App\Models\Detail;
use App\Models\Parfum;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class TransaksiPusat extends Controller
{
    public function index()
    {
        $transact = Transaksi::join('tb_agen', 'tb_transaksi.kode_agen', '=', 'tb_agen.kode_agen')
            ->Where('tb_agen.status', '=', '1')
            ->select('tb_transaksi.*', 'tb_agen.nama_agen')
            ->paginate(10)->onEachSide(1);

        return view('transaksi.Pusat.transaksi', [
            'transact' => $transact,

        ]);

    }
    public function create()
    {
        $agen = Agen::Where('status', '=', '1')->get();
        // dd($agen);
        return view('transaksi.Pusat.transaksi-entry', [
            'agen' => $agen,
        ]);
    }
    public function store(Request $request)
    {
        // $id = $this->dateToDB();

        // dd($request->all());
        $this->validate($request, [

            'kode_agen' => 'required',
            'tanggal' => 'required',
            'jenis' => 'required',

        ]);

        // dd(['id' => $id, $request->all()]);

        // dd(['id' => $this->tes('T-')]);
        Transaksi::create([

            'kode_transaksi' => $this->generateId('T'),
            'kode_agen' => $request->kode_agen,
            'tanggal' => $this->dateToDB(),
            'jenis' => $request->jenis,
            'valid' => 0,

        ]);
        return redirect('/transaksi');
    }
    public function edit(string $id)
    {
        $transact = Transaksi::find($id);
        $agen = Agen::Where('status', '=', '1')->get();
        $dateFromField = $transact->tanggal;
        $date = Carbon::parse($dateFromField)->format('d/m/Y');
        // dd($date);
        return view('transaksi.Pusat.transaksi-edit', [
            'agen' => $agen,
            'transact' => $transact,
            'date' => $date,
        ]);
    }

    public function update(Request $request, string $id)
    {
        // $id = $this->dateToDB();
        $this->validate($request, [
            'kode_agen' => 'required',
            'tanggal' => 'required',
            'jenis' => 'required',
            'valid' => 'required',
        ]);
        // dd(['id' => $id]);
        $transact = Transaksi::find($id);
        $transact->update([

            'kode_agen' => $request->kode_agen,
            'tanggal' => $this->dateToDB(),
            'jenis' => $request->jenis,
            'valid' => $request->valid,
        ]);
        return redirect('/transaksi');
    }

    public static function dateToDB()
    {
        $selectedDate = request()->input('tanggal');
        $date = Carbon::createFromFormat('d/m/Y', $selectedDate); // Create a Carbon instance from the date string
        $formattedDate = $date->format('Y-m-d H:i:s');
        return $formattedDate;
    }
    public static function generateId($prefix)
    {

        $selectedDate = request()->input('tanggal');
        $date = Carbon::createFromFormat('d/m/Y', $selectedDate)->format('dmy');
        $lastTransaksiId = Transaksi::where('kode_transaksi', 'like', $prefix . $date . '%')
            ->orderByDesc('kode_transaksi')
            ->first();

        if (!$lastTransaksiId) {
            $increment = 1;
        } else {
            $lastDate = substr($lastTransaksiId->kode_transaksi, strlen($prefix), 6);
            if ($lastDate !== $date) {
                $increment = 1;
            } else {
                $lastIncrement = substr($lastTransaksiId->kode_transaksi, -3);
                $increment = intval($lastIncrement) + 1;
            }
        }

        $suffix = str_pad($increment, 3, '0', STR_PAD_LEFT);
        return $prefix . $date . $suffix;
    }
    public function drop()
    {
        Schema::dropIfExists('tb_transaksi');
    }

    public function laporTampil()
    {
        $today = Carbon::today()->format('d/m/Y');
        $Agen = Agen::distinct('kode_agen')->select('kode_agen', 'nama_agen')->get();
        $transact = DB::table('tb_transaksi_detail')
        ->join('tb_transaksi','tb_transaksi_detail.kode_transaksi','=','tb_transaksi.kode_transaksi')
        ->join('tb_agen','tb_transaksi.kode_agen','=','tb_agen.kode_agen')
        ->join('tb_parfum','tb_parfum.kode_barang','=','tb_transaksi_detail.kode_barang')
        ->Where('tb_transaksi.valid','=','1')
        ->where('tb_transaksi.jenis','=','Masuk')
        ->where('tb_agen.kode_agen','=','PU001')
        ->whereMonth('tb_transaksi.tanggal', Carbon::now()->month)
        ->select([
            DB::raw('tb_transaksi_detail.kode_barang'),
            DB::raw('tb_parfum.nama_barang'),
            DB::raw('tb_parfum.h_beli'),
            DB::raw('tb_parfum.h_agen'),
            DB::raw('tb_agen.nama_agen'),
            DB::raw('sum(jumlah) as total_brg'),
            DB::raw('sum(harga) as total_harga'),
            DB::raw('tb_transaksi.valid')
        ])->groupBy('tb_transaksi_detail.kode_barang','tb_parfum.nama_barang','tb_parfum.h_beli','tb_parfum.h_agen','tb_transaksi.valid','tb_agen.nama_agen')
        ->get();

        $hargaAll = Parfum::join('tb_transaksi_detail','tb_transaksi_detail.kode_barang','=','tb_parfum.kode_barang')
        ->get();
        
        
        return view('lapor/transaksi/transaksi', [
            'transact' => $transact,
            'hargaAll' => $hargaAll,
            'Agen' => $Agen,
            'today' => $today,
        ]);
    }
    public function laporTproses(Request $request)
    {
        $today = Carbon::today()->format('d/m/Y');
        $Agen = Agen::distinct('kode_agen')->select('kode_agen', 'nama_agen')->get();
        $tang1 = $request->tanggal1;
        $newdatefrom = Carbon::createFromFormat('d/m/Y' , $tang1)->format('Y-m-d');
        $date = $request->tanggal2;
        $newdateto = Carbon::createFromFormat('d/m/Y' , $date)->format('Y-m-d');

        $transact = DB::table('tb_transaksi_detail')
        ->join('tb_transaksi','tb_transaksi_detail.kode_transaksi','=','tb_transaksi.kode_transaksi')
        ->join('tb_agen','tb_transaksi.kode_agen','=','tb_agen.kode_agen')
        ->join('tb_parfum','tb_parfum.kode_barang','=','tb_transaksi_detail.kode_barang')
        ->Where('tb_transaksi.valid','=','1')
        ->where('tb_transaksi.jenis','=',$request->jenis)
        ->where('tb_agen.kode_agen','=', $request->namaAgen)
        ->whereBetween('tb_transaksi.tanggal',[$newdatefrom,$newdateto])
        ->select([
            DB::raw('tb_transaksi_detail.kode_barang'),
            DB::raw('tb_parfum.nama_barang'),
            DB::raw('tb_agen.nama_agen'),
            DB::raw('tb_parfum.h_beli'),
            DB::raw('tb_parfum.h_agen'),
            DB::raw('sum(jumlah) as total_brg'),
            DB::raw('sum(harga) as total_harga'),
            DB::raw('tb_transaksi.valid')
        ])->groupBy('tb_transaksi_detail.kode_barang','tb_parfum.nama_barang','tb_parfum.h_beli','tb_parfum.h_agen','tb_transaksi.valid','tb_transaksi.jenis','tb_agen.nama_agen')
        ->get();
        // dd($transact);
         session(['newdatefrom' => $newdatefrom]);
         session(['newdateto'=> $newdateto]);
         session(['jenis' => $request->jenis]);
         session(['namaAgen' => $request->namaAgen]);
        return view('lapor/transaksi/transaksi', [
            'transact' => $transact,
            'Agen' => $Agen,
            'today' => $today,
            
        ]);
    }
    public function export_excel()
	{
		$newdatefrom = session('newdatefrom');
        $newdateto = session('newdateto');
        $jenis = session('jenis');
        $kode_agen = session('namaAgen');
        
		return Excel::download(new TransaksiWithDateExport($newdatefrom,$newdateto,$jenis,$kode_agen), 'Transaksi Dengan Filter.xlsx');
	}
    public function export_excel_all()
    {
        return Excel::download(new TransaksiExport, 'Semua Transaksi Bulan ini.xlsx');
    }
}
