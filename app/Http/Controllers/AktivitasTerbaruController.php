<?php

namespace App\Http\Controllers;

use App\Services\AktivitasTerbaruInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AktivitasTerbaruController extends Controller
{
    private AktivitasTerbaruInterface $service;

    public function __construct(AktivitasTerbaruInterface $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try{
            $data = $this->service->getData();
            return response()->json([
                'status' => 200,
                'message' => 'Data aktivitas terbaru berhasil diambil',
                'data' => $data
            ], 200);
        }catch(\Throwable $th){
            throw new HttpException(500, $th->getMessage());
        }
    }
}
