<?php

namespace App\Http\Controllers;

use App\Http\Requests\formPermohonanRequest\createFormPermohonanRequest;
use App\Models\FormPermohonanInformasi;
use App\Services\FormPermohonanInformasiInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FormPermohonanInformasiController extends Controller
{
    private FormPermohonanInformasiInterface $form;
    public function __construct(FormPermohonanInformasiInterface $form) {
        $this->form = $form;
    }
    public function index()
    {
        try {
            $data = $this->form->getAllFormPermohonanInformasi();
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
            $data = $this->form->createFormPermohonanInformasi($request->validated());
            return response()->json([
                'status' => 200,
                'message' => 'Data form permohonan informasi berhasil disimpan',
                'data' => $data
            ]);
            
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $formData = FormPermohonanInformasi::findOrFail($id);
            $this->form->deleteFormPermohonanInformasi($formData);

            return response()->json([
                'status' => 200,
                'message' => 'Data form permohonan informasi berhasil dihapus'
            ]);
        }catch(ModelNotFoundException $e){
            return response()->json([
                'status' => 404,
                'message' => 'Data form permohonan informasi tidak ditemukan'
            ], 404);
        }
        catch(\Throwable $e){
            throw new HttpException(500, $e->getMessage());
        }
    }
}
