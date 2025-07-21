<?php

namespace App\Http\Controllers;

use App\Http\Requests\KategoriDokumenRequest\createRequest;
use App\Http\Requests\KategoriDokumenRequest\updateRequest;
use App\Models\KategoriDokumen;
use App\Services\DataServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class KategoriDokumenController extends Controller
{
    private DataServiceInterface $service;

    public function __construct(DataServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(){
        try {
            $data = $this->service->getData();

            return response()->json([
                'status' => 200,
                'message' => 'Data semua kategori dokumen berhasil diambil',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
    public function getKategoriInformasiPublik(){
        try {
            $data = KategoriDokumen::where('jenis_dokumen', 'Informasi Publik')->get();

            if($data->isEmpty()){
               return response()->json([
                   'status' => 404,
                   'message' => 'Data kategori informasi publik tidak ditemukan'
               ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data kategori informasi publik berhasil diambil',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function getKategoriLayananInformasi(){
        try {
            $data = KategoriDokumen::where('jenis_dokumen', 'Layanan Informasi')->get();

            if($data->isEmpty()){
               return response()->json([
                   'status' => 404,
                   'message' => 'Data kategori layanan informasi tidak ditemukan'
               ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data kategori layanan informasi berhasil diambil',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function getKategoriPelayanan(){
        try {
            $data = KategoriDokumen::where('jenis_dokumen', 'Pelayanan')->get();

            if($data->isEmpty()){
               return response()->json([
                   'status' => 404,
                   'message' => 'Data kategori pelayanan tidak ditemukan'
               ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data kategori pelayanan berhasil diambil',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function getKategoriLainnya(){
        try {
            $data = KategoriDokumen::where('jenis_dokumen', 'Lainnya')->get();

            if($data->isEmpty()){
               return response()->json([
                   'status' => 404,
                   'message' => 'Data kategori lainnya tidak ditemukan'
               ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data kategori lainnya berhasil diambil',
                'data' => $data
            ]);
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
                    'message' => 'Data kategori dokumen tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data kategori dokumen berhasil diupdate',
                'data' => $result
            ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    function store(createRequest $request){
        try {
            $validated = $request->validated();
            $user = $request->user();
            $username = $user ? $user->username : null;

            $result = $this->service->createData($validated, $username);
            return response()->json([
                'status' => 201,
                'message' => 'Data kategori dokumen berhasil ditambahkan',
                'data' => $result
            ],201);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    function destroy($id){
        try {
            $user = Auth::user();
            $username = $user ? $user->username : null;
            $result = $this->service->deleteData($id, $username);
            if($result){
                return response()->json([
                    'status' => 200,
                    'message' => 'Data kategori dokumen berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data kategori dokumen tidak ditemukan'
                ]);
            }
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}
