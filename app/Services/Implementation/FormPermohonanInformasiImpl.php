<?php 
namespace App\Services\Implementation;

use App\Models\AktivitasTerbaru;
use App\Models\FormPermohonanInformasi;
use App\Services\FormServiceInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class FormPermohonanInformasiImpl implements FormServiceInterface
{
    public function getForm(){
        try {
            Log::info("Data form permohonan informasi berhasil diambil", [
                "time" => now()->toDateTimeString()
            ]);
            return FormPermohonanInformasi::all();
        } catch (\Throwable $th) {
            Log::error("Gagal ambil data form permohonan informasi", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function createForm(array $data){
        try {
            $data = FormPermohonanInformasi::create($data);
            Log::info("Data form permohonan informasi berhasil ditambahkan", [
                "time" => now()->toDateTimeString()
            ]);
            return $data;
        } catch (\Throwable $th) {
            Log::error("Gagal tambah data form permohonan informasi", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

     public function updateForm($id, array $data,string $username)
    {
        try {
            $form = FormPermohonanInformasi::findOrFail($id);
            $result = $form->update($data);

            if($result){
                Log::info('Data form permohonan informasi berhasil diupdate', [
                    'time' => now()->toDateTimeString()
                ]);
                 // Catat aktivitas
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'update',
                    'deskripsi_aktivitas' => 'Mengubah status',
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);

            }else{
                Log::warning('Data form permohonan informasi gagal diupdate (tidak ada perubahan di database)', [
                    'time' => now()->toDateTimeString()
                ]);
            }
            return $result;
           
        }catch (ModelNotFoundException $e){
            Log::error("Data form permohonan informasi tidak ditemukan untuk diupdate", [
                "id_form" => $id,
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        }catch (\Throwable $th) {
            Log::error("Gagal update data form permohonan informasi", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function deleteForm($id){
        try {
            $form = FormPermohonanInformasi::findOrFail($id);
            $form->delete();
            Log::info("Data form permohonan informasi berhasil dihapus", [
                "time" => now()->toDateTimeString()
            ]);
            return true;
        }catch (ModelNotFoundException $e){
            Log::error("Data form permohonan informasi tidak ditemukan untuk dihapus", [
                "id" => $id,
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Gagal hapus data form permohonan informasi", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
}
?>
