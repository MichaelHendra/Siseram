<?php

namespace App\Http\Controllers;

use App\Models\Parfum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParfumController extends Controller
{
    //
    public function index()
    {

        $parfum = Parfum::paginate(10)->onEachSide(1);
        return view('setting.parfum.parfum', [
            "parfum" => $parfum,
        ]);
        // example:

    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    public function create()
    {
        return view('setting.parfum.parfum-entry');
    }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    public function store(Request $request)
    {
        $this->validate($request, [
            'kode_barang' => 'required|unique:tb_parfum',
            'nama_barang' => 'required',
            'h_beli' => 'required',
            'h_agen' => 'required',
        ]);

        Parfum::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'h_beli' => $request->h_beli,
            'h_agen' => $request->h_agen,
        ]);
        return redirect('/parfum')->with('success', 'Data berhasil ditambahkan');

    }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    public function edit(string $id)
    {
        $parfum = Parfum::find($id);
        return view('setting.parfum.parfum-edit', [
            "parfum" => $parfum,
        ]);

    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nama_barang' => 'required',
            'h_beli' => 'required',
            'h_agen' => 'required',
        ]);

        $parfum = Parfum::find($id);
        $parfum->update([
            'nama_barang' => $request->nama_barang,
            'h_beli' => $request->h_beli,
            'h_agen' => $request->h_agen,
        ]);
        return redirect('/parfum')->with('success', 'Data berhasil diubah');
        //
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    public function mess()
    {
        $data = [
            [
                'kode_barang' => 'A001',
                'nama_barang' => 'Angel Shelecher Man',
                'h_beli' => '175000',
                'h_agen' => '180000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'A002',
                'nama_barang' => 'Angel Shelecher Woman',
                'h_beli' => '175000',
                'h_agen' => '180000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'B001',
                'nama_barang' => 'B. 75 ml Man',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'B002',
                'nama_barang' => 'B. 75 ml Woman',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'B003',
                'nama_barang' => 'B. Blue Paradiso',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'B004',
                'nama_barang' => 'B. Body Spray',
                'h_beli' => '60000',
                'h_agen' => '65000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'B005',
                'nama_barang' => 'B. Essens',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'B006',
                'nama_barang' => 'B. Jeans Man (Set)',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'B007',
                'nama_barang' => 'B. Jeans Man (Tanpa set)',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'B008',
                'nama_barang' => 'B. Jeans Woman (Set)',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'B009',
                'nama_barang' => 'B. Pure Sport Man (Hijau)',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'B010',
                'nama_barang' => 'B. Pure Sport Woman (Set)',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'B011',
                'nama_barang' => 'B. Sport Woman Red (Set)',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'C001',
                'nama_barang' => 'Corduroy',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'F001',
                'nama_barang' => 'Ferari Pasion',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'F002',
                'nama_barang' => 'Ferre B 50 ml',
                'h_beli' => '160000',
                'h_agen' => '165000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'F003',
                'nama_barang' => 'Ferre K 30 ml',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'F004',
                'nama_barang' => 'Friends',
                'h_beli' => '160000',
                'h_agen' => '165000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'F005',
                'nama_barang' => 'Fujiyama',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'M001',
                'nama_barang' => 'Maxmara Besar',
                'h_beli' => '215000',
                'h_agen' => '220000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'M002',
                'nama_barang' => 'Maxmara Silk',
                'h_beli' => '175000',
                'h_agen' => '180000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'R001',
                'nama_barang' => 'Roberto Veriro Aqua',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'R002',
                'nama_barang' => 'Roberto Veriro Rose',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'R003',
                'nama_barang' => 'Roberto Veriro Tropic',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'T001',
                'nama_barang' => 'Tous Gold 30 ml',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'T002',
                'nama_barang' => 'Tous Limited edition',
                'h_beli' => '160000',
                'h_agen' => '165000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'T003',
                'nama_barang' => 'Tous Man',
                'h_beli' => '155000',
                'h_agen' => '160000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'T004',
                'nama_barang' => 'Tous Touch 30 ml',
                'h_beli' => '135000',
                'h_agen' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_barang' => 'T005',
                'nama_barang' => 'Tous Touch 50 ml',
                'h_beli' => '160000',
                'h_agen' => '165000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        DB::table("tb_parfum")->insert($data);
        return redirect('/parfum')->with('success', 'Data banyak ditambahkan');
    }
    public function destroy(string $id)
    {
        //
        $parfum = Parfum::find($id);
        $parfum->delete();
        return redirect('/parfum');
    }
}
