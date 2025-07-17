<?php 
namespace App\Services\Implementation;

use App\Models\AktivitasTerbaru;
use App\Models\FormContactUs;
use App\Services\FormServiceInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class FormContactUsImpl implements FormServiceInterface
{
    public function getForm()
    {
        try {
            $result = FormContactUs::all();
            Log::info('Data form contact us berhasil diambil', [
                'time' => now()->toDateTimeString()
            ]);
            return $result;
        } catch (\Throwable $th) {
            Log::error("Gagal ambil data form contact us", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now()->toDateTimeString()
            ]);
            throw $th;  
        }
    }

    public function createForm(array $data)
    {
        try{
            $data = FormContactUs::create($data);
            Log::info('Data form contact us berhasil ditambahkan', [
                'time' => now()->toDateTimeString()
            ]);
            return $data;
        } catch (\Throwable $th) {
            Log::error("Gagal menambahkan data form contact us", [
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
            $form = FormContactUs::findOrFail($id);
            $result = $form->update($data);

            if($result){
                Log::info('Data form contact us berhasil diupdate', [
                    'time' => now()->toDateTimeString()
                ]);

                // Catat aktivitas
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'update',
                    'deskripsi_aktivitas' => 'Mengubah status data form contact us ('.$data["status"].")",
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);
                

            }else{
                Log::warning('Data form contact us gagal diupdate (tidak ada perubahan di database)', [
                    'time' => now()->toDateTimeString()
                ]);
            }
            return $result;
           
        }catch (ModelNotFoundException $e){
            Log::error("Data form contact us tidak ditemukan untuk diupdate", [
                "id_form" => $id,
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        }catch (\Throwable $th) {
            Log::error("Gagal update data form contact us", [
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
            $form = FormContactUs::findOrFail($id);
            $form->delete();
            Log::info("Data form contact us berhasil dihapus", [
                "time" => now()->toDateTimeString()
            ]);

            // Catat aktivitas
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'delete',
                    'deskripsi_aktivitas' => 'Menghapus data form contact us',
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);
            return true;
        }catch (ModelNotFoundException $e){
            Log::error("Data form contact us tidak ditemukan untuk dihapus", [
                "id_form" => $id,
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Gagal hapus data form contact us", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
}
?>