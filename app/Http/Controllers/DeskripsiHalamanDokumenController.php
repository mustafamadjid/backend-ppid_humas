<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerBerandaRequest\updateRequest;
use App\Http\Requests\DeskripsiHalamanDokumenRequest\createRequest;
use App\Services\DeskripsiHalamanDokumenInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DeskripsiHalamanDokumenController extends Controller
{
    private DeskripsiHalamanDokumenInterface $service;

    public function __construct(DeskripsiHalamanDokumenInterface $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = $this->service->getData();
            return response()->json([
                'status' => 200,
                'message' => 'Data semua deskripsi halaman dokumen berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function getDataByKategori(string $kategori)
    {
        try {
            $data = $this->service->getDataByKategori($kategori);

            if (!$data) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data deskripsi halaman dokumen tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data deskripsi halaman dokumen berhasil diambil',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function store(createRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = $request->user();
            $username = $user ? $user->username : null;

            $data = $this->service->createData($validated, $username);

            return response()->json([
                'status' => 201,
                'message' => 'Data deskripsi halaman dokumen berhasil ditambahkan',
                'data' => $data
            ], 201);
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

            $data = $this->service->updateData($id, $validated, $username);

            if (!$data) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data deskripsi halaman dokumen tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data deskripsi halaman dokumen berhasil diupdate',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = request()->user();
            $username = $user ? $user->username : null;

            $data = $this->service->deleteData($id, $username);

            if (!$data) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data deskripsi halaman dokumen tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data deskripsi halaman dokumen berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}
