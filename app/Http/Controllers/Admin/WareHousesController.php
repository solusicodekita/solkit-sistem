<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class WareHousesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Warehouse::latest('id')->get();
        return view('admin.warehouses.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.warehouses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255',
            ],
            [
                'name.required' => 'Nama kategori wajib diisi.',
                'code.required' => 'Kode kategori wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        $check = Warehouse::where('name', $request->input('name'))->exists();
        if ($check) {
            return response()->json([
                'status' => 500,
                'message' => 'Nama lokasi sudah ada dalam database'
            ], 500);
        }

        try {
            DB::beginTransaction();
            $lokasi = new Warehouse();
            $lokasi->name = $request->input('name');
            $lokasi->code = $request->input('code');
            $lokasi->created_by = Auth::user()->id;
            $lokasi->save();
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Data lokasi berhasil di Simpan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'message' => 'Gagal menyimpan data. Pesan Kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lokasi = Warehouse::find($id);
        return view('admin.warehouses.show',compact('lokasi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lokasi = Warehouse::find($id);
        return view('admin.warehouses.edit',compact('lokasi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255',
            ],
            [
                'name.required' => 'Nama kategori wajib diisi.',
                'code.required' => 'Kode kategori wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $cekDataLama = Warehouse::find($request->input('id'));

        if ($cekDataLama->name == $request->input('name')) {
            $check = false;
        } else {
            $check = Warehouse::where('name', $request->input('name'))->where('id', '!=', $id)->exists();
        }

        if ($check) {
            return response()->json([
                'status' => 500,
                'message' => 'Nama lokasi sudah ada dalam database'
            ], 500);
        }

        try {
            DB::beginTransaction();
            $lokasi = Warehouse::find($request->input('id'));
            $lokasi->name = $request->input('name');
            $lokasi->code = $request->input('code');
            $lokasi->updated_by = Auth::user()->id;
            $lokasi->save();
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Data lokasi berhasil diubah',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'message' => 'Gagal menyimpan data. Pesan Kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lokasi = Warehouse::find($id);
        $lokasi->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data lokasi berhasil dihapus',
        ]);
    }

    public function checkName(Request $request)
    {
        dd($request->all());
        $name = $request->input('name');
        $exists = Warehouse::where('name', $name)->exists();
        return response()->json(['exists' => $exists]);
    }
}
