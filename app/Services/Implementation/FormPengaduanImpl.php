<?php 
namespace App\Services\Implementation;

use App\Models\FormPengaduan;
use App\Services\FormPengaduanInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FormPengaduanImpl implements FormPengaduanInterface
{
    public function createFormPengaduan(array $data)
    {
        try {
           

            Log::info("Data pengaduan berhasil ditambahkan",["time" => now()]);
            return FormPengaduan::create($data);
        } catch (\Throwable $e) {
            Log::error("Data pengaduan gagal ditambahkan",["time" => now()]);
            throw $e;
            
        }
    }

    public function getFormPengaduan()
    {
        try {
            $pengaduan = FormPengaduan::all();
            Log::info("Data pengaduan berhasil diambil",["time" => now()]);
            return $pengaduan;
        } catch (\Throwable $e) {
            Log::error("Data pengaduan gagal diambil",["time" => now()]);
            throw $e;
        }
    }

    public function deleteFormPengaduan(FormPengaduan $pengaduan)
    {
        try {
            if($pengaduan->path_file_bukti && Storage::disk('public')->exists($pengaduan->path_file_bukti)){
                Storage::disk('public')->delete($pengaduan->path_file_bukti);
            }

            $pengaduan->delete();
            Log::info("Data pengaduan berhasil dihapus",["time" => now()]);
            return true;
        } catch (\Throwable $e) {
            Log::error("Data pengaduan gagal dihapus",["time" => now()]);
            throw $e;
        }
    }
}

?>