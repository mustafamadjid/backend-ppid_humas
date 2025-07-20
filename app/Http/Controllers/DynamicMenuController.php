<?php

namespace App\Http\Controllers;

use App\Http\Requests\menuDataRequest\createMenuRequest;
use App\Http\Requests\menuDataRequest\updateMenuRequest;
use App\Models\DynamicMenu;
use App\Services\DataServiceInterface;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DynamicMenuController extends Controller
{
    private DataServiceInterface $dynamicMenuService;
    public function __construct(DataServiceInterface $dynamicMenuService)
    {
        $this->dynamicMenuService = $dynamicMenuService;
    }   
    
    public function store(createMenuRequest $request) {
        try {
            $validated = $request->validated();
            $user = $request->user();
            $username = $user ? $user->username : null;

            $data = $this->dynamicMenuService->createData($validated, $username);
            
            Log::info('Data menu berhasil ditambahkan', [
                'data' => $validated
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Data menu berhasil ditambahkan',
                'data' => $data
            ], 200);
            
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function index(){
        try {
            $data = $this->dynamicMenuService->getData();

            return response()->json([
                'status' => 200,
                'message' => 'Data semua menu berhasil diambil',
                'data' => $data
            ], 200);
        
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function update(updateMenuRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $user = $request->user();
            $username = $user ? $user->username : null;

            $data = $this->dynamicMenuService->updateData($id, $validated, $username);

            if (!$data) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Menu tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data menu berhasil diupdate',
                'data' => $data
            ]);
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = request()->user();
            $username = $user ? $user->username : null;

            $result = $this->dynamicMenuService->deleteData($id, $username);

            if (!$result) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Menu tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data menu berhasil dihapus',
            ]);
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

}
