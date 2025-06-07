<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Imports\ItemImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Item::orderBy('code')->get();
        return view('admin.items.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Category::latest('id')->get();
        return view('admin.items.create', compact('data'));
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
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'unit' => 'required|string|max:255',
                'price' => 'required|',
            ],
            [
                'category_id.required' => 'Kategori wajib diisi.',
                'category_id.exists' => 'Kategori tidak valid.',
                'name.required' => 'Nama bahan wajib diisi.',
                'unit.required' => 'Unit wajib diisi.',
                'price.required' => 'Harga wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $category = Category::where('id', $request->input('category_id'))->first();
            DB::beginTransaction();
            $bahan = new Item();
            $bahan->category_id = $request->input('category_id');
            $bahan->code = $this->generateKode($category->code);
            $bahan->name = $request->input('name');
            $bahan->unit = $request->input('unit');
            $bahan->price = (int) str_replace(['Rp', '.', ' '], '', $request->input('price'));
            $bahan->created_by = Auth::user()->id;
            $bahan->save();
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Data bahan berhasil di Simpan',
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
        $category = Category::find($id);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori = Category::latest('id')->get();
        $data = Item::find($id);
        $data->price = 'Rp ' . number_format($data->price, 0, ',', '.');
        
        return view('admin.items.edit', compact('kategori', 'data'));
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
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'unit' => 'required|string|max:255',
                'price' => 'required|',
            ],
            [
                'category_id.required' => 'Kategori wajib diisi.',
                'category_id.exists' => 'Kategori tidak valid.',
                'name.required' => 'Nama bahan wajib diisi.',
                'unit.required' => 'Unit wajib diisi.',
                'price.required' => 'Harga wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $category = Category::where('id', $request->input('category_id'))->first();
            DB::beginTransaction();
            $bahan = Item::find($request->input('id'));
            
            // Cek apakah category_id berubah
            if ($bahan->category_id != $request->input('category_id')) {
                // Generate kode baru jika kategori berubah
                $bahan->code = $this->generateKode($category->code);
            }
            
            $bahan->category_id = $request->input('category_id');
            $bahan->name = $request->input('name');
            $bahan->unit = $request->input('unit');
            $bahan->price = (int) str_replace(['Rp', '.', ' '], '', $request->input('price'));
            $bahan->updated_by = Auth::user()->id;
            $bahan->save();
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Data bahan berhasil diubah',
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
        $bahan = Item::find($id);
        $bahan->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data item berhasil dihapus',
        ]);
    }

    public function generateKode($categoryCode)
    {
        $latestItem = Item::where('code', 'like', $categoryCode . '%')
            ->orderBy('code', 'desc')
            ->first();

        if (!$latestItem) {
            return $categoryCode . '00001';
        }

        $numericPart = substr($latestItem->code, strlen($categoryCode));
        $nextNumber = intval($numericPart) + 1;

        return $categoryCode . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public function import()
    {
        $data = Category::latest('id')->get();
        return view('admin.items.import', compact('data'));
    }

    public function importData(Request $request)
    {
       $validator = Validator::make(
            $request->all(),
            [
                'file' => 'required|mimes:xlsx,xls',
            ],
            [
                'file.required' => 'File wajib diisi.',
                'file.mimes' => 'File harus berupa xlsx atau xls.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            Excel::import(new ItemImport, $request->file('file'));
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil diimport',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
