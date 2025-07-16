<?php
namespace App\Services;

interface DashboardServiceInterface
{
    public function countDokumen();
    public function countFormPengaduan();
    public function countFormPengajuan();
    public function countFormPermohonan();
    public function countAdmin();
}
?>