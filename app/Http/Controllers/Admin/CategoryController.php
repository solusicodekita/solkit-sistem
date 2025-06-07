<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::latest('id')->get();
        return view('admin.categories.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
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

        $check = Category::where('name', $request->input('name'))->exists();
        if ($check) {
            return response()->json([
                'status' => 500,
                'message' => 'Nama kategori sudah ada dalam database'
            ], 500);
        }

        try {
            DB::beginTransaction();
            $kategori = new Category();
            $kategori->name = $request->input('name');
            $kategori->code = $request->input('code');
            $kategori->slug = strtolower(str_replace(' ', '-', $request->input('name')));
            $kategori->created_by = Auth::user()->id;
            $kategori->save();
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Data kategori berhasil di Simpan',
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
        return view('admin.categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit',compact('category'));
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

        $cekDataLama = Category::find($request->input('id'));

        if ($cekDataLama->name == $request->input('name')) {
            $check = false;
        } else {
            $check = Category::where('name', $request->input('name'))->where('id', '!=', $id)->exists();
        }

        if ($check) {
            return response()->json([
                'status' => 500,
                'message' => 'Nama kategori sudah ada dalam database'
            ], 500);
        }

        try {
            DB::beginTransaction();
            $kategori = Category::find($request->input('id'));
            $kategori->name = $request->input('name');
            $kategori->code = $request->input('code');
            $kategori->slug = strtolower(str_replace(' ', '-', $request->input('name')));
            $kategori->updated_by = Auth::user()->id;
            $kategori->save();
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Data kategori berhasil diubah',
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
        $kategori = Category::find($id);
        $kategori->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data kategori berhasil dihapus',
        ]);
    }
}
