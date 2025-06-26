<?php

namespace App\Http\Controllers;

use App\Http\Requests\formKeberatanRequest\createFormKeberatanRequest;
use App\Http\Requests\formKeberatanRequest\createFormRequest;
use App\Models\FormKeberatan;
use App\Services\FormKeberatanInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FormKeberatanController extends Controller
{
    private FormKeberatanInterface $formKeberatanService;

    public function __construct(FormKeberatanInterface $formKeberatanService)
    {
        $this->formKeberatanService = $formKeberatanService;
    }
    public function index(){
        try {
            $data = $this->formKeberatanService->getAllFormKeberatan();

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

            $this->formKeberatanService->createFormKeberatan($data);
            
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
            $form = FormKeberatan::findOrFail($id);
            $this->formKeberatanService->deleteFormKeberatan($form);

            return response()->json([
                'status' => 200,
                'message' => 'Data form keberatan berhasil dihapus'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Data form keberatan tidak ditemukan'
            ], 404);
        }catch(\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}
