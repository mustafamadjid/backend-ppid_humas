<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerBerandaRequest\createRequest;
use App\Http\Requests\BannerBerandaRequest\updateRequest;
use App\Services\DataServiceInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BannerBerandaController extends Controller
{
    private DataServiceInterface $banner;
    public function __construct(DataServiceInterface $banner){
        $this->banner = $banner;
    }
    public function index()
    {
        try {
            $data = $this->banner->getData();
            return response()->json([
                'status' => 200,
                'message' => 'Data semua gambar banner beranda berhasil diambil',
                'data' => $data
            ]);
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function store(createRequest $request)
    {
        try {
            $user = $request->user();
            $username = $user ? $user->username : null;
            
            $file = $request->file('file_gambar');
            $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
            $path = $file->storePubliclyAs('banner_beranda', $uniqueName, 'public');

            $data = array_merge(
                $request->validated(),
                ['path_gambar' => $path]
            );

            $result = $this->banner->createData($data, $username);

            return response()->json([
                'status' => 201,
                'message' => 'Data gambar banner beranda berhasil ditambahkan',
                'data' => $result
            ], 201);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function update(updateRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $user = $request->user();
            $username = $user ? $user->username : null;

            if ($request->hasFile('file_gambar')) {
                $file = $request->file('file_gambar');
                $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storePubliclyAs('banner_beranda', $uniqueName, 'public');
                $data['path_gambar'] = $path;
            }

            $result = $this->banner->updateData($id, $data, $username);

            if (!$result) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data gambar banner beranda tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data gambar banner beranda berhasil diupdate',
                'data' => $result
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

           
            $result = $this->banner->deleteData($id, $username);

            if (!$result) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data gambar banner beranda tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data gambar banner beranda berhasil dihapus',
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}
