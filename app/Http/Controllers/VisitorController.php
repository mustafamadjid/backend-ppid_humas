<?php

namespace App\Http\Controllers;

use App\Services\VisitorServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VisitorController extends Controller
{
    private VisitorServiceInterface $service;
    public function __construct(VisitorServiceInterface $service)
    {
        $this->service = $service;
    }

    public function getTotalVisitor(){
        try {
            $data = $this->service->getTotalVisitor();

            return response()->json([
                'status' => 200,
                'message' => 'Data total visitor berhasil diambil',
                'data' => [
                    'total_visitor' => $data
                ]
                ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $ip = $request->ip();
            $result = $this->service->countVisitor($ip);
            Log::info("IP", [
                'ip' => $ip
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Data visitor berhasil dihitung',
                'data' => $result
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function getVisitorToday(){
        try {
            $data = $this->service->countVisitorToday();
            return response()->json([
                'status' => 200,
                'message' => 'Data total visitor hari ini berhasil diambil',
                'data' => [
                    'total_visitor' => $data
                ]
                ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}
