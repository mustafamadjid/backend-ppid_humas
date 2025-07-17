<?php

namespace App\Http\Controllers;

use App\Http\Requests\formPermohonanRequest\createFormPermohonanRequest;
use App\Http\Requests\formPermohonanRequest\updateRequest;
use App\Models\FormPermohonanInformasi;
use App\Services\FormPermohonanInformasiInterface;
use App\Services\FormServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FormPermohonanInformasiController extends Controller
{
    private FormServiceInterface $form;

    public function __construct(FormServiceInterface $form)
    {
        $this->form = $form;
    }
    public function index()
    {
        try {
            $data = $this->form->getForm();
            return response()->json([
                'status' => 200,
                'message' => 'Data semua form permohonan informasi berhasil diambil',
                'data' => $data
            ]);
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function store(createFormPermohonanRequest $request)
    {
        try {
            $data = $this->form->createForm($request->validated());
            return response()->json([
                'status' => 200,
                'message' => 'Data form permohonan informasi berhasil disimpan',
                'data' => $data
            ]);
            
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

     public function update(updateRequest $request, $id)
    {
        try{
            $validated = $request->validated();
            $user = $request->user();
            $username = $user ? $user->username : null;

            $result = $this->form->updateForm($id, $validated, $username);

            if(!$result){
                return response()->json([
                    'status' => 404,
                    'message' => 'Data form permohonan informasi tidak ditemukan'
                ], 404);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Data form pengajuan keberatan berhasil diupdate',
                'data' => $result
            ], 200);
           
        }catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $user = Auth::user();
            $username = $user ? $user->username : null;
            
            $result = $this->form->deleteForm($id, $username);

            if (!$result) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data form permohonan informasi tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data form permohonan informasi berhasil dihapus'
            ]);
        }catch(\Throwable $e){
            throw new HttpException(500, $e->getMessage());
        }
    }
}
