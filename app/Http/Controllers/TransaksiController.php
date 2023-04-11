<?php

namespace App\Http\Controllers;
use App\Models\Agen;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TransaksiController extends Controller
{
    public function index()
    {
        $agen = Agen::all();
        $transact = Transaksi::all();
        return view('transaksi.transaksi', [
            'agen' => $agen,
            'transact' => $transact,
        ]);

    }
    public function create()
    {
        $agen = Agen::all();
        return view('transaksi.transaksi-entry', [
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
        $agen = Agen::all();
        $dateFromField = $transact->tanggal;
        $date = Carbon::parse($dateFromField)->format('d/m/Y');
        // dd($date);
        return view('transaksi.transaksi-edit', [
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
}
