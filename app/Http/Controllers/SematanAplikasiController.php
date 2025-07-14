<?php

namespace App\Http\Controllers;

use App\Http\Requests\SematanAplikasiRequest\createRequest;
use App\Http\Requests\SematanAplikasiRequest\updateRequest;
use App\Services\DataServiceInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SematanAplikasiController extends Controller
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
                'message' => 'Data semua sematan aplikasi berhasil diambil',
                'data' => $data
            ], 200);

        } catch(\Throwable $th){
            throw new HttpException(500, $th->getMessage());
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
                'message' => 'Data sematan aplikasi berhasil ditambahkan',
                'data' => $result
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
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
                    'message' => 'Data sematan aplikasi tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data sematan aplikasi berhasil diupdate',
                'data' => $result
            ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = request()->user();
            $username = $user ? $user->username : null;

            $result = $this->service->deleteData($id, $username);

            if (!$result) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data sematan aplikasi tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data sematan aplikasi berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}
