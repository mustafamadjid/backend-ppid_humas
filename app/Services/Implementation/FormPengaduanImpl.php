<?php 
namespace App\Services\Implementation;

use App\Models\FormPengaduan;
use App\Services\FormServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FormPengaduanImpl implements FormServiceInterface
{
    public function createForm(array $data)
    {
        try {
           

            Log::info("Data pengaduan berhasil ditambahkan",["time" => now()]);
            return FormPengaduan::create($data);
        } catch (\Throwable $th) {
           Log::error("Gagal menambahkan data pengaduan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
            
        }
    }

    public function getForm()
    {
        try {
            $pengaduan = FormPengaduan::all();
            Log::info("Data pengaduan berhasil diambil",["time" => now()]);
            return $pengaduan;
        } catch (\Throwable $th) {
            Log::error("Gagal ambil data pengaduan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }

    public function deleteForm(Model $form)
    {
        try {
            if($form->path_file_bukti && Storage::disk('public')->exists($form->path_file_bukti)){
                Storage::disk('public')->delete($form->path_file_bukti);
            }

            $form->delete();
            Log::info("Data pengaduan berhasil dihapus",["time" => now()]);
            return true;
        } catch (\Throwable $th) {
            Log::error("Gagal menghapus data pengaduan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }
}

?>