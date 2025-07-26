<?php

namespace App\Http\Controllers;

use App\Models\TahunDokumenTampil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class tahunDokumenTampilController extends Controller
{
    public function index() {
        try {
            $data = TahunDokumenTampil::all();
            Log::info("Data tahun dokumen yang akan tampil berhasil diambil", [
                "time" => now()->toDateTimeString()
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Data tahun dokumen yang akan tampil berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
           Log::error($th->getMessage());
           throw new HttpException(500, $th->getMessage());
        }
    }

    public function store(Request $request) {
        try {
            $data = TahunDokumenTampil::create($request->all());
            Log::info("Data tahun dokumen yang akan tampil berhasil ditambahkan", [
                "time" => now()->toDateTimeString()
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Data tahun dokumen yang akan tampil berhasil ditambahkan',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = TahunDokumenTampil::findOrFail($id);
            $data->update($request->all());
            Log::info("Data tahun dokumen yang akan tampil berhasil diubah", [
                "time" => now()->toDateTimeString()
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Data tahun dokumen yang akan tampil berhasil diubah',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw new HttpException(500, $th->getMessage());
        }
    }
}
