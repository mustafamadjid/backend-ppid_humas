<?php

namespace App\Http\Controllers;

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
    public function store(Request $request){
        try {
            $validated = Validator::make($request->all(), [
                'nama_dokumen' => [
                    'required',
                    'string',
                    'max:100'
                ],
                'kategori_dokumen' => [
                    'required',
                    'string',
                    'max:100'   
                ],
                'tahun_dokumen' => [
                    'required',
                    'integer',
                    "min:1900",
                    "max:2100"
                    
                ],
                'file_dokumen' => [
                    'required',
                    'file',
                    'mimes:jpeg,pdf',
                    'max:20480'
                ]
            ]);

            if($validated->fails()){
                return response()->json([
                    'status' => 422,
                    'message' => 'Dokumen publik gagal ditambahkan',
                    'errors' => $validated->errors()
                ], 422);
            }
            $file = $request->file('file_dokumen');
            $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
            $path = $file->storePubliclyAs('dokumen', $uniqueName, 'public');

            $data = array_merge(
                $validated->validated(),
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
    public function update(Request $request, $id){
        try {
            $dokumen = DokumenPublik::findOrFail($id);

            $validated = Validator::make($request->all(), [
                'nama_dokumen' => [
                    'sometimes',
                    'string',
                    'max:100'
                ],
                'path_dokumen' => [
                    'sometimes',
                    'string',
                    'url'
                ],
                'kategori_dokumen' => [
                    'sometimes',
                    'string',
                    'max:100'   
                ],
                'tahun_dokumen' => [
                    'sometimes',
                    'integer',
                    "min:1900",
                    "max:2100"
                ]
                ]);

            if($validated->fails()){
                return response()->json([
                    'status' => 422,
                    'message' => 'Dokumen publik gagal diupdate',
                    'errors' => $validated->errors()
                ], 422);
            }

            $data = $this->dokumen->updateDokumenPublik($dokumen,$validated->validated());
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
