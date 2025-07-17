<?php
namespace App\Services\Implementation;

use App\Models\AktivitasTerbaru;
use App\Models\FormKeberatan;
use App\Services\FormServiceInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FormKeberatanServiceImpl implements FormServiceInterface
{
    public function getForm()
    {
        try {
            $result = FormKeberatan::all();
            Log::info('Data form keberatan berhasil diambil', [
                'time' => now()->toDateTimeString()
            ]);
            return $result;
        } catch (\Throwable $th) {
            Log::error("Gagal ambil data form keberatan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function createForm(array $data)
    {
        try {
            Log::info('Data form keberatan berhasil ditambahkan', [
                'time' => now()->toDateTimeString()
            ]);
            return FormKeberatan::create($data);
        } catch (\Throwable $th) {
            Log::error("Gagal menambahkan data form keberatan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

     public function updateForm($id, array $data,string $username)
    {
        try {
            $form = FormKeberatan::findOrFail($id);
            $result = $form->update($data);

            if($result){
                Log::info('Data form pengajuan keberatan berhasil diupdate', [
                    'time' => now()->toDateTimeString()
                ]);
                 // Catat aktivitas
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'update',
                    'deskripsi_aktivitas' => 'Mengubah status data form pengajuan keberatan ('.$data["status"].")",
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);
            }else{
                Log::warning('Data form pengajuan keberatan gagal diupdate (tidak ada perubahan di database)', [
                    'time' => now()->toDateTimeString()
                ]);
            }
            return $result;
           
        }catch (ModelNotFoundException $e){
            Log::error("Data form pengajuan keberatan tidak ditemukan untuk diupdate", [
                "id_form" => $id,
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        }catch (\Throwable $th) {
            Log::error("Gagal update data form pengajuan keberatan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function deleteForm($id,string $username)
    {
        try {
            $form = FormKeberatan::findOrFail($id);

            $result = $form->delete();
            
            if($result){
                Log::info("Data form keberatan berhasil dihapus", [
                    "time" => now()->toDateTimeString()
                ]);
            }else{
                Log::warning("Data form keberatan gagal dihapus (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }

            Log::info('Data form keberatan berhasil dihapus', [
                'time' => now()->toDateTimeString()
            ]);

            AktivitasTerbaru::create([
                'username' => $username,
                'jenis_aktivitas' => 'delete',
                'deskripsi_aktivitas' => 'Delete form keberatan',
                'waktu_aktivitas' => Carbon::now()->toDateTimeString()
            ]);
            return true;
        }catch (ModelNotFoundException $e){
            Log::error("Data form keberatan tidak ditemukan untuk dihapus", [
                "id" => $id,
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Gagal menghapus data form keberatan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
}
?>
