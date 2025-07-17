<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Model;

interface DashboardServiceInterface
{
    public function countDokumen();
    public function countFormPengaduan();
    public function countFormPengajuan();
    public function countFormPermohonan();
    public function countAdmin();
     public function countStatusForm(Model $model);
}
?>