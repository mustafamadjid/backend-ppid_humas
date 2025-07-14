<?php

namespace App\Http\Controllers;

use App\Http\Requests\JabatanOrganisasiRequest\updateRequest;
use App\Http\Requests\JabatanOrganisasiRequest\createRequest;
use App\Services\DataServiceInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class JabatanOrganisasiController extends Controller
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
                'message' => 'Data semua jabatan organisasi berhasil diambil',
                'data' => $data
            ],200);
        } catch (\Throwable $e) {
            throw new HttpException(500,$e->getMessage());
        }
    }

    public function store(createRequest $request){
        try {
            $validated = $request->validated();
            $user = $request->user();
            $username = $user ? $user->username : null;

            $data = $this->service->createData($validated, $username);

            return response()->json([
                'status' => 201,
                'message' => 'Data jabatan organisasi berhasil dibuat',
                'data' => $data
            ],201);
        } catch (\Throwable $e) {
            throw new HttpException(500,$e->getMessage());
        }
    }

    public function update(updateRequest $request, $id){
        try {
            $validated = $request->validated();
            $user = $request->user();
            $username = $user ? $user->username : null;

            $data = $this->service->updateData($id, $validated, $username);

            if(!$data){
                return response()->json([
                    'status' => 404,
                    'message' => 'Data jabatan organisasi tidak ditemukan'
                ],404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data jabatan organisasi berhasil diupdate',
                'data' => $data
            ],200);
        }catch (\Throwable $e) {
            throw new HttpException(500,$e->getMessage());
        }
    }

    public function destroy($id){
        try {
            $user = request()->user();
            $username = $user ? $user->username : null;

            $data = $this->service->deleteData($id, $username);

            if(!$data){
                return response()->json([
                    'status' => 404,
                    'message' => 'Data jabatan organisasi tidak ditemukan'
                ],404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data jabatan organisasi berhasil dihapus',
                'data' => $data
            ],200);
        }catch (\Throwable $e) {
            throw new HttpException(500,$e->getMessage());
        }
    }
}
