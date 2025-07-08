<?php

namespace App\Http\Controllers;

use App\Http\Requests\formPengaduanRequest\createFormPengaduanRequest;
use App\Models\FormPengaduan;
use App\Services\FormServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FormPengaduanController extends Controller
{
    private FormServiceInterface $form;

    public function __construct(FormServiceInterface $form)
    {
        $this->form = $form;
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
            

            $this->form->createForm($data);

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
            $data = $this->form->getForm();

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
           $result = $this->form->deleteForm($id);

            if (!$result) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data pengaduan tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data pengaduan berhasil dihapus'
            ], 200);
        }catch(\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}
