<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PengaturanController extends Controller
{
    public function index()
    {
        $model = User::where('id', Auth::user()->id)->first();
        return view('admin.pengaturan.index', compact('model'));
    }
    
    public function updatePassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'new_password' => 'required|',
            ],
            [
                'new_password.required' => 'Nama kategori wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }
        try {
            DB::beginTransaction();
            $user = User::where('id', Auth::user()->id)->first();
            $user->password = bcrypt($request->input('new_password'));
            $user->save();
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Password berhasil diubah',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'message' => 'Gagal menyimpan data. Pesan Kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
