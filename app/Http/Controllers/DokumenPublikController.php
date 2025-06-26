<?php

namespace App\Http\Controllers;

use App\Http\Requests\dokumenDataRequest\createDokumenRequest;
use App\Http\Requests\dokumenDataRequest\updateDokumenRequest;
use App\Models\DokumenPublik;
use App\Services\DokumenPublikInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DokumenPublikController extends Controller
{
    private DokumenPublikInterface $dokumen;
    public function __construct (DokumenPublikInterface $dokumen){
        $this->dokumen = $dokumen;
    }

    public function index(){
        try {
            $data = $this->dokumen->getDokumenPublik();

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

            $data = $this->dokumen->createDokumenPublik($data);
            return response()->json([
                'status' => 200,
                'message' => 'Dokumen publik berhasil ditambahkan',
                'data' => $data
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

            $data = $this->dokumen->updateDokumenPublik($dokumen,$data);
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
            $this->dokumen->deleteDokumenPublik($dokumen);
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
