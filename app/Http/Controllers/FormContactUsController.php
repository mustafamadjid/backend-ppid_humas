<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormContactUsRequest\createRequest;
use App\Services\FormServiceInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FormContactUsController extends Controller
{
    private FormServiceInterface $service;

    public function __construct(FormServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = $this->service->getForm();

            return response()->json([
                'status' => 200,
                'message' => 'Data semua form contact us berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function store(createRequest $request)
    {
        try{
            $validated = $request->validated();
            $result = $this->service->createForm($validated);
            
            return response()->json([
                'status' => 200,
                'message' => 'Data form contact us berhasil ditambahkan',
                'data' => $result
            ], 200);
        }catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $result = $this->service->deleteForm($id);

            if (!$result) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data form contact us tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data form contact us berhasil dihapus',
                'data' => $result
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}
