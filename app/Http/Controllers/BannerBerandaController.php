<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerBerandaRequest\createRequest;
use App\Http\Requests\BannerBerandaRequest\updateRequest;
use App\Models\BannerBeranda;
use App\Services\BannerBerandaInterface;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
            throw new HttpException(500,$e->getMessage());
        }
    }
    public function store(createRequest $request)
    {
        try {
            $file = $request->file('file_gambar');
            $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
            $path = $file->storePubliclyAs('banner_beranda', $uniqueName, 'public');

            $data = array_merge(
                $request->validated(),
                ['path_gambar' => $path]
            );

            $result = $this->banner->createData($data);
            return response()->json([
                'status' => 201,
                'message' => 'Data gambar banner beranda berhasil ditambahkan',
                'data' => $result
            ], 201);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
    public function update(updateRequest $request,$id)
    {
        try {
            $bannerBeranda = BannerBeranda::findOrFail($id);
            $file = $request->file('file_gambar');
            $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
            $path = $file->storePubliclyAs('banner_beranda', $uniqueName, 'public');

            $data = array_merge(
                $request->validated(),
                ['path_gambar' => $path]
            );

            $result = $this->banner->updateData($bannerBeranda,$data);
            return response()->json([
                'status' => 200,
                'message' => 'Data gambar banner beranda berhasil diupdate',
                'data' => $result
            ], 200);
        } catch(ModelNotFoundException $e){
            return response()->json([
                'status' => 404,
                'message' => 'Data gambar banner beranda tidak ditemukan'
            ], 404);
        }
         catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $bannerBeranda = BannerBeranda::findOrFail($id);
            $this->banner->deleteData($bannerBeranda);
            return response()->json([
                'status' => 200,
                'message' => 'Data gambar banner beranda berhasil dihapus',
            ], 200);
        } catch(ModelNotFoundException $e){
            return response()->json([
                'status' => 404,
                'message' => 'Data gambar banner beranda tidak ditemukan'
            ], 404);
        }
         catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}
