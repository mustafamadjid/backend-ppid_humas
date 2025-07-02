<?php

namespace App\Http\Controllers;

use App\Http\Requests\menuDataRequest\createMenuRequest;
use App\Http\Requests\menuDataRequest\updateMenuRequest;
use App\Models\DynamicMenu;
use App\Services\DataServiceInterface;
use App\Services\DynamicMenuInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
          

            $data = $this->dynamicMenuService->createData($request->validated());

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

    public function update(updateMenuRequest $request,$id){
        try {
            $menu = DynamicMenu::findOrFail($id);
            $data = $this->dynamicMenuService->updateData($menu, $request->validated());

            return response()->json([
                'status' => 200,
                'message' => 'Data menu berhasil diupdate',
                'data' => $data
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Menu tidak ditemukan'
            ], 404);
        }catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function destroy($id){
        try {
            $menu = DynamicMenu::findOrFail($id);
            $this->dynamicMenuService->deleteData($menu);

            return response()->json([
                'status' => 200,
                'message' => 'Data menu berhasil dihapus',
            ]);
    }catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Menu tidak ditemukan'
            ], 404);
        }catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}
