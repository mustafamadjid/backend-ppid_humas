<?php

namespace App\Http\Controllers;

use App\Models\FormContactUs;
use App\Models\FormKeberatan;
use App\Models\FormPengaduan;
use App\Models\FormPermohonanInformasi;
use App\Services\DashboardServiceInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DashboardServiceController extends Controller
{
    private DashboardServiceInterface $service;
    public function __construct(DashboardServiceInterface $service){
        $this->service = $service;
    }

    public function countDokumen()
    {
        try {
            $count = $this->service->countDokumen();

            return response()->json([
                'status' => 200,
                'message' => 'Total data dokumen berhasil diambil',
                'data' => [
                    'total' => $count
                ]
            ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function countFormPengaduan()
    {
        try {
            $count = $this->service->countFormPengaduan();

            return response()->json([
                'status' => 200,
                'message' => 'Total data form pengaduan berhasil diambil',
                'data' => [
                    'total' => $count
                ]
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
                'data' => [
                    'total' => $count
                ]
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
                'data' => [
                    'total' => $count
                ]
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
                'data' => [
                    'total' => $count
                ]
            ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function countStatusFormContactUs()
    {
        try {
            $model = new FormContactUs();
            $count = $this->service->countStatusForm($model);

            return response()->json([
                'status' => 200,
                'message' => 'Total data form contact us berhasil diambil',
                'data' => [
                    'total' => $count['total'],
                    'belum_diproses' => $count['belum_diproses'],
                    'sedang_diproses' => $count['sedang_diproses'],
                    'selesai' => $count['selesai']
                ]
                ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function countStatusFormPengaduan()
    {
        try {
            $model = new FormPengaduan();
            $count = $this->service->countStatusForm($model);

            return response()->json([
                'status' => 200,
                'message' => 'Total data form pengaduan berhasil diambil',
                'data' => [
                    'total' => $count['total'],
                    'belum_diproses' => $count['belum_diproses'],
                    'sedang_diproses' => $count['sedang_diproses'],
                    'selesai' => $count['selesai']
                ]
                ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function countStatusFormPengajuanKeberatan()
    {
        try {
            $model = new FormKeberatan();
            $count = $this->service->countStatusForm($model);

            return response()->json([
                'status' => 200,
                'message' => 'Total data form pengajuan berhasil diambil',
                'data' => [
                    'total' => $count['total'],
                    'belum_diproses' => $count['belum_diproses'],
                    'sedang_diproses' => $count['sedang_diproses'],
                    'selesai' => $count['selesai']
                ]
                ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function countStatusFormPermohonan()
    {
        try {
            $model = new FormPermohonanInformasi();
            $count = $this->service->countStatusForm($model);

            return response()->json([
                'status' => 200,
                'message' => 'Total data form permohonan berhasil diambil',
                'data' => [
                    'total' => $count['total'],
                    'belum_diproses' => $count['belum_diproses'],
                    'sedang_diproses' => $count['sedang_diproses'],
                    'selesai' => $count['selesai']
                ]
                ]);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}
