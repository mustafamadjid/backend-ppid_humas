<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfilPpidRequest\createRequest;
use App\Http\Requests\ProfilPpidRequest\updateRequest;
use App\Services\DataServiceInterface;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProfilPpidController extends Controller
{
    private DataServiceInterface $service;

    public function __construct(DataServiceInterface $service){
        $this->service = $service;
    }
    public function index()
    {
        try {
            $data = $this->service->getData();
            return response()->json([
                'status' => 200,
                'message' => 'Data semua profil ppid berhasil diambil',
                'data' => $data
            ]);
        } catch (\Throwable $e) {
            throw new HttpException(500,$e->getMessage());
        }
    }

    public function store(createRequest $request)
    {
        try {
            $data = $request->validated();

            $result = $this->service->createData($data);

            return response()->json([
                'status' => 200,
                'message' => 'Data profil ppid berhasil ditambahkan',
                'data' => $result
            ]);
        } catch (\Throwable $e) {
            throw new HttpException(500,$e->getMessage());
        }
    }

    public function update(updateRequest $request, $id)
    {
        try {
            $data = $request->validated();

            $result = $this->service->updateData($id,$data);

            if(!$result){
                return response()->json([
                    'status' => 404,
                    'message' => 'Data profil ppid tidak ditemukan'
                ],404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data profil ppid berhasil diupdate',
                'data' => $result
            ]);
        } catch (\Throwable $e) {
            throw new HttpException(500,$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $result = $this->service->deleteData($id);

            if(!$result){
                return response()->json([
                    'status' => 404,
                    'message' => 'Data profil ppid tidak ditemukan'
                ],404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data profil ppid berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw new HttpException(500,$th->getMessage());
        }
    }
}
