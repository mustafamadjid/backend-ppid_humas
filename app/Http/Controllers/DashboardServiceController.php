<?php

namespace App\Http\Controllers;

use App\Services\DashboardServiceInterface;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DashboardServiceController extends Controller
{
    private DashboardServiceInterface $service;
    public function __construct(DashboardServiceInterface $service){
        $this->service = $service;
    }
   public function countFormPengaduan()
   {
    try {
          $count = $this->service->countFormPengaduan();

          return response()->json([
              'status' => 200,
              'message' => 'Total data form pengaduan berhasil diambil',
              'data' => $count
          ]);
    } catch (\Throwable $th) {
        throw new HttpException(500, $th->getMessage());
    }
   }

   public function countFormPengajuanKeberatan()
   {
    try {
        $count = $this->service->countFormPengajuan();

        return response()->json([
            'status' => 200,
            'message' => 'Total data form pengajuan keberatan berhasil diambil',
            'data' => $count
        ]);
    } catch (\Throwable $th) {
        throw new HttpException(500, $th->getMessage());
    }
   }

   public function countFormPermohonan()
   {
    try {
        $count = $this->service->countFormPermohonan();

        return response()->json([
            'status' => 200,
            'message' => 'Total data form permohonan berhasil diambil',
            'data' => $count
        ]);
    } catch (\Throwable $th) {
        throw new HttpException(500, $th->getMessage());
    }
   }

   public function countAdmin()
   {
    try {
        $count = $this->service->countAdmin();

        return response()->json([
            'status' => 200,
            'message' => 'Total data admin berhasil diambil',
            'data' => $count
        ]);
    } catch (\Throwable $th) {
        throw new HttpException(500, $th->getMessage());
    }
   }
}
