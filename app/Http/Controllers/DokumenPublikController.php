<?php

namespace App\Http\Controllers;

use App\Http\Requests\dokumenDataRequest\createDokumenRequest;
use App\Http\Requests\dokumenDataRequest\updateDokumenRequest;
use App\Models\DokumenPublik;
use App\Services\DokumenServiceInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

use function Laravel\Prompts\error;

class DokumenPublikController extends Controller
{
    private DokumenServiceInterface $dokumen;
    public function __construct (DokumenServiceInterface $dokumen){
        $this->dokumen = $dokumen;
    }

    public function index(){
        try {
            $data = $this->dokumen->getData();

            return response()->json([
                'status' => 200,
                'message' => 'Data semua dokumen publik berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function getDataByTahunKategori($kategori, $tahun){
        try {
            
            $data = $this->dokumen->getDataByTahun((int)$tahun, $kategori);

            if(!$data){
                return response()->json([
                    'status' => 404,
                    'message' => 'Data dokumen tidak ditemukan'
                ],404);
            }

            if (Storage::disk('public')->exists($data->path_dokumen)) {
                $url = asset('storage/' . $data->path_dokumen);
            } else {
                $url = null;
            }

            Log::info("Data dokumen berhasil diambil", [
                "time" => now()->toDateTimeString()
            ]);
            return response()->json([
                'status' => 200,
                'message' => "Data dokumen berhasil diambil",
                'data' => $data,
                'url' => $url
            ]);
            
        }catch (\Throwable $e) {
            Log::error( $e->getMessage());
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function showDataByKategori($kategori){
        try {
            $data = $this->dokumen->getDataByKategori($kategori);

            if(!$data){
                return response()->json([
                    'status' => 404,
                    'message' => 'Data dokumen tidak ditemukan'
                ],404);
            }

            if (Storage::disk('public')->exists($data->path_dokumen)) {
                $url = asset('storage/' . $data->path_dokumen);
            } else {
                $url = null;
            }

            return response()->json([
                'status' => 200,
                'message' => "Data dokumen berhasil diambil",
                'data' => $data,
                'url' => $url
            ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function getAllTahun(){
    try {
        $data = DokumenPublik::select('tahun_dokumen')->distinct()->orderBy('tahun_dokumen', 'asc')->pluck('tahun_dokumen');

        return response()->json([
            'status' => 200,
            'message' => 'Data tahun dokumen berhasil diambil',
            'data' => $data
        ], 200);
    } catch (\Throwable $th) {
        throw new HttpException(500, $th->getMessage());
        }
    }

    public function getAllKategori(){
        try {
            $data = DokumenPublik::select('kategori_dokumen')->distinct()->orderBy('kategori_dokumen', 'asc')->pluck('kategori_dokumen');

            Log::info("Data kategori dokumen berhasil diambil", [
                "time" => now()->toDateTimeString()
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Data kategori dokumen berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function getAllKategoriByJenis($jenis_dokumen){
        try {
            $data = DokumenPublik::where('jenis_dokumen',$jenis_dokumen)
                    ->select('kategori_dokumen')
                    ->distinct()
                    ->orderBy('kategori_dokumen', 'asc')
                    ->pluck('kategori_dokumen');

            Log::info("Data kategori dokumen berhasil diambil", [
                "time" => now()->toDateTimeString()
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Data kategori dokumen berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function downloadData($filename)
{
    try {
        // Cegah directory traversal 
        if (strpos($filename, '..') !== false) {
            return response()->json([
                'status' => 400,
                'message' => 'Path tidak valid'
            ], 400);
        }

        
        if (!Storage::disk('public')->exists($filename)) {
            return response()->json([
                'status' => 404,
                'message' => 'File tidak ditemukan'
            ], 404);
        }

        $path = storage_path('app/public/' . $filename);

        // Download file
        return response()->download($path);
    } catch (\Throwable $e) {
        Log::error($e->getMessage());
        throw new HttpException(500, $e->getMessage());
    }
}


    

    public function store(createDokumenRequest $request){
        try {
            $validated = $request->validated();
            $user = $request->user();
            $username = $user ? $user->username : null;

            if($request->hasFile('file_dokumen')) {
                $file = $request->file('file_dokumen');
                $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storePubliclyAs('dokumen', $uniqueName, 'public');
                $validated['path_dokumen'] = $path;
            }

            $result = $this->dokumen->createData($validated, $username);

            return response()->json([
                'status' => 201,
                'message' => 'Dokumen publik berhasil ditambahkan',
                'data' => $result
            ], 201);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function update(updateDokumenRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $user = $request->user();
            $username = $user ? $user->username : null;

            if ($request->hasFile('file_dokumen')) {
                $file = $request->file('file_dokumen');
                $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storePubliclyAs('dokumen', $uniqueName, 'public');
                $validated['path_dokumen'] = $path;
            }

            $updated = $this->dokumen->updateData($id, $validated, $username);

            if (!$updated) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Dokumen publik tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Dokumen publik berhasil diupdate',
                'data' => $updated
            ], 200);

        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = request()->user();
            $username = $user ? $user->username : null;

            $deleted = $this->dokumen->deleteData($id, $username);

            if (!$deleted) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Dokumen publik tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Dokumen publik berhasil dihapus'
            ], 200);

        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}
