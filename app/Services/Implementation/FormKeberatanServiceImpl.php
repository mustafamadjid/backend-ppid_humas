<?php
namespace App\Services\Implementation;

use App\Models\FormKeberatan;


use App\Services\FormServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FormKeberatanServiceImpl implements FormServiceInterface
{
    public function getForm()
    {
        try {
            Log::info('Data form keberatan berhasil diambil');
             return FormKeberatan::all();
        } catch (\Throwable $th) {
            Log::error("Gagal ambil data form keberatan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }

    public function createForm(array $data)
    {
        try {
            Log::info('Data form keberatan berhasil ditambahkan');
            return FormKeberatan::create($data);
        } catch (\Throwable $th) {
            Log::error("Gagal menambahkan data form keberatan", [
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
            Log::info('Data form keberatan berhasil dihapus');
            return true;
        } catch (\Throwable $th) {
            Log::error("Gagal menghapus data form keberatan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }
}


?>