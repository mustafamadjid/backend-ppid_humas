<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaklumatPelayananRequest\createRequest;
use App\Http\Requests\MaklumatPelayananRequest\updateRequest;
use App\Models\MaklumatPelayanan;
use App\Services\DataServiceInterface;
use App\Services\MaklumatPelayananServiceInterfce;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MaklumatPelayananController extends Controller
{
    private DataServiceInterface $maklumatPelayanan;
    public function __construct(DataServiceInterface $maklumatPelayanan)
    {
        $this->maklumatPelayanan = $maklumatPelayanan;
    }

    public function index()
    {
        try {
            $data = $this->maklumatPelayanan->getData();

            return response()->json([
                'status' => 200,
                'message' => 'Data semua maklumat pelayanan berhasil diambil',
                'data' => $data
            ],200);
        } catch (\Throwable $e) {
            throw new HttpException(500,$e->getMessage());
        }
    }
    public function store(createRequest $request)
    {
        try {
            $data = $this->maklumatPelayanan->createData($request->validated());
            return response()->json([
                'status' => 201,
                'message' => 'Data maklumat pelayanan berhasil dibuat',
                'data' => $data
            ],201);
        } catch (\Throwable $e) {
           throw new HttpException(500,$e->getMessage());
        }
    }
    public function update(updateRequest $request,$id)
    {
        try {
            $data = $this->maklumatPelayanan->updateData($id,$request->validated());

            if(!$data){
                return response()->json([
                    'status' => 404,
                    'message' => 'Data maklumat pelayanan tidak ditemukan'
                ],404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data maklumat pelayanan berhasil diupdate',
                'data' => $data
            ],200);
        }
        catch (\Throwable $e) {
            throw new HttpException(500,$e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $data = $this->maklumatPelayanan->deleteData($id);

            if(!$data){
                return response()->json([
                    'status' => 404,
                    'message' => 'Data maklumat pelayanan tidak ditemukan'
                ],404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data maklumat pelayanan berhasil dihapus',
                'data' => $data
            ]);
        }catch (\Throwable$e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
    
}
