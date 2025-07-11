<?php

namespace App\Http\Controllers;

use App\Http\Requests\dokumenDataRequest\createDokumenRequest;
use App\Http\Requests\dokumenDataRequest\updateDokumenRequest;
use App\Models\DokumenPublik;
use App\Services\DataServiceInterface;
use App\Services\DokumenServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

    public function getDataByTahun($tahun,$kategori){
        try {
            $data = $this->dokumen->getDataByTahun($tahun,$kategori);

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
            
        }catch (\Throwable $e) {
            throw new HttpException(500,$e->getMessage());
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

    public function downloadData($filename){
        try {
            
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
    
            return response()->download(storage_path('app/public/' . $filename));
    
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
    

    public function store(createDokumenRequest $request){
        try {
            $data = $request->validated();

            if($request->hasFile('file_dokumen')) {
                $file = $request->file('file_dokumen');
                $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storePubliclyAs('dokumen', $uniqueName, 'public');
                $data['path_dokumen'] = $path;
            }

            $result = $this->dokumen->createData($data);
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
            $data = $request->validated();

            if ($request->hasFile('file_dokumen')) {
                $file = $request->file('file_dokumen');
                $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storePubliclyAs('dokumen', $uniqueName, 'public');
                $data['path_dokumen'] = $path;
            }

            $updated = $this->dokumen->updateData($id, $data);

            if (!$updated) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Dokumen publik tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Dokumen publik berhasil diupdate',
                'data' => $updated // atau bisa hanya $data, sesuai kebutuhan
            ], 200);

        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->dokumen->deleteData($id);

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
