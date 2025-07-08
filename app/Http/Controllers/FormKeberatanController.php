<?php

namespace App\Http\Controllers;

use App\Http\Requests\formKeberatanRequest\createFormKeberatanRequest;

use App\Models\FormKeberatan;

use App\Services\FormServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Symfony\Component\HttpKernel\Exception\HttpException;

class FormKeberatanController extends Controller
{
    private FormServiceInterface $form;

    public function __construct(FormServiceInterface $form)
    {
        $this->form = $form;
    }
    public function index(){
        try {
            $data = $this->form->getForm();

            return response()->json([
                'status' => 200,
                'message' => 'Data semua form keberatan berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function store(createFormKeberatanRequest $request){
        try {
            $file = $request->file('file_bukti');
            $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
            $path = $file->storePubliclyAs('bukti_pengajuan_keberatan', $uniqueName, 'public');

            $data = array_merge(
                $request->validated(),
                ['path_file_bukti' => $path]
            );

            $this->form->createForm($data);
            
            return response()->json([
                'status' => 200,
                'message' => 'Data form keberatan berhasil ditambahkan',
                'data' => $data
            ], 200);
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function destroy($id){
        try {
           $result = $this->form->deleteForm($id);

            if (!$result) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data form keberatan tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data form keberatan berhasil dihapus'
            ], 200);
        }catch(\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}
