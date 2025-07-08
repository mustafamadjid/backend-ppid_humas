<?php

namespace App\Http\Controllers;

use App\Http\Requests\JabatanOrganisasiRequest\updateRequest;
use App\Http\Requests\JabatanOrganisasiRequest\createRequest;
use App\Models\JabatanOrganisasi;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
            $data = $this->service->createData($request->validated());
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
            $data = $this->service->updateData($id,$request->validated());

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
            $data = $this->service->deleteData($id);

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
