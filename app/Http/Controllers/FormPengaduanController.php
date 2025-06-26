<?php

namespace App\Http\Controllers;

use App\Http\Requests\formPengaduanRequest\createFormPengaduanRequest;
use App\Models\FormPengaduan;
use App\Services\FormPengaduanInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FormPengaduanController extends Controller
{
    private FormPengaduanInterface $formPengaduan;
    public function __construct(FormPengaduanInterface $formPengaduan){
        $this->formPengaduan = $formPengaduan;
    }

    public function store (createFormPengaduanRequest $request){
        try {
            
            
            $file = $request->file('file_bukti');
            $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
            $path = $file->storePubliclyAs('bukti_pengaduan', $uniqueName, 'public');

            $data = array_merge(
                $request->validated(),
                ['path_file_bukti' => $path]
            );
            

            $this->formPengaduan->createFormPengaduan($data);

            return response()->json([
                'status' => 200,
                'message' => 'Data pengaduan berhasil ditambahkan',
                'data' => $data
            ]);

        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    } 

    public function index(){
        try {
            $data = $this->formPengaduan->getFormPengaduan();

            return response()->json([
                'status' => 200,
                'message' => 'Data semua pengaduan berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function destroy( $id){
        try {
            $dataForm = FormPengaduan::findOrFail($id);

            $this->formPengaduan->deleteFormPengaduan($dataForm);

            return response()->json([
                'status' => 200,
                'message' => 'Data pengaduan berhasil dihapus'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Pengaduan tidak ditemukan'
            ], 404);
        }catch(\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}
