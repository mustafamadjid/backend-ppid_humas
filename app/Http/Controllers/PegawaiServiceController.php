<?php

namespace App\Http\Controllers;

use App\Http\Requests\PegawaiRequest\createRequest;
use App\Http\Requests\PegawaiRequest\updateRequest;
use App\Services\DataServiceInterface;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PegawaiServiceController extends Controller
{
    private DataServiceInterface $service;
    public function __construct(DataServiceInterface $service)
    {
        $this->service = $service;    
    }

    public function index()
    {
        try {
            $data = $this->service->getData();
            return response()->json([
                'status' => 200,
                'message' => 'Data semua pegawai berhasil diambil',
                'data' => $data
            ],200);
        } catch (\Throwable $th) {
            throw new HttpException(500,$th->getMessage());
        }
    }
    public function store(createRequest $request)
    {
        try {
            $data = $request->validated();

            if($request->hasFile('file_gambar')) {
                $file = $request->file('file_gambar');
                $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storePubliclyAs('foto_pegawai', $uniqueName, 'public');
                $data['path_foto_pegawai'] = $path;
            }

            $result = $this->service->createData($data);
            return response()->json([
                'status' => 201,
                'message' => 'Data pegawai berhasil ditambahkan',
                'data' => $result
            ],201);
        } catch (\Throwable $th) {
            throw new HttpException(500,$th->getMessage());
        }
    }
    public function update(updateRequest $request, $id)
    {
        try {
            $data = $request->validated();

            if($request->hasFile('file_gambar')) {
                $file = $request->file('file_gambar');
                $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storePubliclyAs('foto_pegawai', $uniqueName, 'public');
                $data['path_foto_pegawai'] = $path;
            }

            $result = $this->service->updateData($id,$data);

            if(!$result) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data pegawai tidak ditemukan'
                ],404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data pegawai berhasil diupdate',
                'data' => $result
            ]);
        } catch (\Throwable $th) {
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
                    'message' => 'Data pegawai tidak ditemukan'
                ], 404);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Data pegawai berhasil dihapus'
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}
