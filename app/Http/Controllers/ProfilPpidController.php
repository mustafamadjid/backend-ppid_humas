<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfilPpidRequest\createRequest;
use App\Http\Requests\ProfilPpidRequest\updateRequest;
use App\Services\DataServiceInterface;
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
            ], 200);
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function store(createRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = $request->user();
            $username = $user ? $user->username : null;

            $result = $this->service->createData($validated, $username);

            return response()->json([
                'status' => 200,
                'message' => 'Data profil ppid berhasil ditambahkan',
                'data' => $result
            ], 200);
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function update(updateRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $user = $request->user();
            $username = $user ? $user->username : null;

            $result = $this->service->updateData($id, $validated, $username);

            if(!$result){
                return response()->json([
                    'status' => 404,
                    'message' => 'Data profil ppid tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data profil ppid berhasil diupdate',
                'data' => $result
            ], 200);
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = request()->user();
            $username = $user ? $user->username : null;

            $result = $this->service->deleteData($id, $username);

            if(!$result){
                return response()->json([
                    'status' => 404,
                    'message' => 'Data profil ppid tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data profil ppid berhasil dihapus'
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}
