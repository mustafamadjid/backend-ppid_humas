<?php

namespace App\Http\Controllers;

use App\Http\Requests\GambarSopRequest\createRequest;
use App\Http\Requests\GambarSopRequest\updateRequest;
use App\Models\GambarSop;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GambarSopController extends Controller
{

    private DataServiceInterface $service;

    public function __construct(DataServiceInterface $service){
        $this->service = $service;
    }
    public function index(){
        try {
            $data = $this->service->getData();
            return response()->json([
                'status' => 200,
                'message' => 'Data semua gambar sop berhasil diambil',
                'data' => $data
            ]);
        } catch (\Throwable $e) {
            throw new HttpException(500,$e->getMessage());
        }
    }
    public function store(createRequest $request){
        try {
            $file = $request->file('file_gambar');
            $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
            $path = $file->storePubliclyAs('gambar_sop_beranda', $uniqueName, 'public');

            $data = array_merge(
                $request->validated(),
                ['path_gambar' => $path]
            );

            $result = $this->service->createData($data);
            return response()->json([
                'status' => 201,
                'message' => 'Data gambar sop berhasil ditambahkan',
                'data' => $result
            ], 201);
        } catch (\Throwable $th) {
            throw new HttpException(500,$th->getMessage());
        }
    }
    public function update(updateRequest $request, $id){
        try {
        
        $data = $request->validated();

        if ($request->hasFile('file_gambar')) {
            $file = $request->file('file_gambar');
            $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
            $path = $file->storePubliclyAs('gambar_sop_beranda', $uniqueName, 'public');

            
            $data['path_gambar'] = $path;
        }

        $result = $this->service->updateData($id, $data);

        if (!$result) {
            return response()->json([
                'status' => 404,
                'message' => 'Data gambar sop tidak ditemukan'
            ],404);
        }
        
        return response()->json([
            'status' => 200,
            'message' => 'Data gambar sop berhasil diupdate',
            'data' => $data
        ],200);
        }catch (\Throwable $th) {
            throw new HttpException(500,$th->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $result = $this->service->deleteData($id);

            if (!$result) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data gambar sop tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data gambar sop berhasil dihapus'
            ], 200);

        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

}
