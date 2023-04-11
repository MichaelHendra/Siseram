<?php

namespace App\Http\Controllers;

use App\Models\Agen;
use Illuminate\Http\Request;

class AgenController extends Controller
{
    public function index()
    {
        //

        $agen = Agen::all();
        return view('setting.agen.agen', [
            "agen" => $agen,
        ]);
        // example:

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('setting.agen.agen-entry');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'kode_agen' => 'required|unique:tb_agen',
            'nama_agen' => 'required',
        ]);

        Agen::create([
            'kode_agen' => $request->kode_agen,
            'nama_agen' => $request->nama_agen,
            'status' => $request->status,
        ]);
        return redirect('/agen')->with('success', 'Data berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $agen = Agen::find($id);
        return view('setting.agen.agen-edit', [
            "agen" => $agen,
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nama_agen' => 'required',
        ]);

        $agen = Agen::find($id);
        $agen->update([
            'nama_agen' => $request->nama_agen,
            'status' => $request->status,
        ]);
        return redirect('/agen')->with('success', 'Data berhasil diubah');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $agen = Agen::find($id);
        $agen->delete();
        return redirect('/agen');
    }
}
