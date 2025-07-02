<?php

namespace App\Http\Controllers;

use App\Http\Requests\dokumenDataRequest\createDokumenRequest;
use App\Http\Requests\dokumenDataRequest\updateDokumenRequest;
use App\Models\DokumenPublik;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DokumenPublikController extends Controller
{
    private DataServiceInterface $dokumen;
    public function __construct (DataServiceInterface $dokumen){
        $this->dokumen = $dokumen;
    }

    public function index(){
        try {
            $data = $this->dokumen->getData();

            return response()->json([
                'status' => 200,
                'message' => 'Data semua dokumen publik berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
    public function store(createDokumenRequest $request){
        try {
            $file = $request->file('file_dokumen');
            $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
            $path = $file->storePubliclyAs('dokumen', $uniqueName, 'public');

            $data = array_merge(
                $request->validated(),
                ['path_dokumen' => $path]
            );

            $result = $this->dokumen->createData($data);
            return response()->json([
                'status' => 200,
                'message' => 'Dokumen publik berhasil ditambahkan',
                'data' => $result
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
    public function update(updateDokumenRequest $request, $id){
        try {
            $dokumen = DokumenPublik::findOrFail($id);
            
            $file = $request->file('file_dokumen');
            $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
            $path = $file->storePubliclyAs('dokumen', $uniqueName, 'public');

            $data = array_merge(
                $request->validated(),
                ['path_dokumen' => $path]
            );

            $data = $this->dokumen->updateData($dokumen,$data);
            return response()->json([
                'status' => 200,
                'message' => 'Dokumen publik berhasil diupdate',
                'data' => $data
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Dokumen publik tidak ditemukan'
            ], 404);
        }catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
    public function destroy($id){
        try {
            $dokumen = DokumenPublik::findOrFail($id);
            $this->dokumen->deleteData($dokumen);
            return response()->json([
                'status' => 200,
                'message' => 'Dokumen publik berhasil dihapus'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Dokumen publik tidak ditemukan'
            ],404);
        }catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

}
