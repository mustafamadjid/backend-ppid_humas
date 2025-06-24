<?php
namespace App\Services\Implementation;

use App\Models\FormKeberatan;

use App\Services\FormKeberatanInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FormKeberatanServiceImpl implements FormKeberatanInterface
{
    public function getAllFormKeberatan()
    {
        try {
            Log::info('Data form keberatan berhasil diambil');
             return FormKeberatan::all();
        } catch (\Throwable $e) {
            Log::error('Data form keberatan gagal diambil');
            throw $e;
        }
    }

    public function createFormKeberatan(array $data)
    {
        try {
            Log::info('Data form keberatan berhasil ditambahkan');
            return FormKeberatan::create($data);
        } catch (\Throwable $e) {
            Log::error('Data form keberatan gagal ditambahkan');
            throw $e;
        }
    }

    public function deleteFormKeberatan(FormKeberatan $form)
    {
       try {
            if($form->path_file_bukti && Storage::disk('public')->exists($form->path_file_bukti)){
                Storage::disk('public')->delete($form->path_file_bukti);
            }
            $form->delete();
            Log::info('Data form keberatan berhasil dihapus');
            return true;
        } catch (\Throwable $e) {
            Log::error('Data form keberatan gagal dihapus');
            throw $e;
        }
    }
}


?>