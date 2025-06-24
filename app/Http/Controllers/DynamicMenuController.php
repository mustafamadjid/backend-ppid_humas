<?php

namespace App\Http\Controllers;

use App\Models\DynamicMenu;
use App\Services\DynamicMenuInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DynamicMenuController extends Controller
{
    private DynamicMenuInterface $dynamicMenuService;
    public function __construct(DynamicMenuInterface $dynamicMenuService)
    {
        $this->dynamicMenuService = $dynamicMenuService;
    }   
    public function store(Request $request) {
        try {
            $validated = Validator::make($request->all(), [
                'judul_menu' => [
                    'required',
                    'string',
                    'max:150',
                ],
                'url' => [
                    'required',
                    'string',
                    'url'
                ]
            ]);

            if($validated->fails()){
                return response()->json([
                    'status' => 422,
                    'message' => 'Data menu gagal ditambahkan',
                    'errors' => $validated->errors()
                ], 422);
            }

            $data = $this->dynamicMenuService->createDynamicMenu($request->all());

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
            $data = $this->dynamicMenuService->getDynamicMenu();

            return response()->json([
                'status' => 200,
                'message' => 'Data semua menu berhasil diambil',
                'data' => $data
            ], 200);
        
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function update(Request $request,$id){
        try {
            $menu = DynamicMenu::findOrFail($id);

            $validated = Validator::make($request->all(), [
                'judul_menu' => [
                    'sometimes',
                    'string',
                    'max:150',
                ],
                'url' => [
                    'sometimes',
                    'string',
                    'url'
                ]
            ]);

            if($validated->fails()){
                return response()->json([
                    'status' => 422,
                    'message' => 'Data menu gagal diupdate',
                    'errors' => $validated->errors()
                ], 422);
            };

            $data = $this->dynamicMenuService->updateDynamicMenu($menu, $validated->validated());

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
            $this->dynamicMenuService->deleteDynamicMenu($menu);

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
