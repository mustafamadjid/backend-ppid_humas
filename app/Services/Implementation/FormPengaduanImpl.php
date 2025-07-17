<?php 
namespace App\Services\Implementation;

use App\Models\AktivitasTerbaru;
use App\Models\FormPengaduan;
use App\Services\FormServiceInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FormPengaduanImpl implements FormServiceInterface
{
    public function createForm(array $data)
    {
        try {
            Log::info("Data pengaduan berhasil ditambahkan", [
                "time" => now()->toDateTimeString()
            ]);
            return FormPengaduan::create($data);
        } catch (\Throwable $th) {
            Log::error("Gagal menambahkan data pengaduan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function getForm()
    {
        try {
            $pengaduan = FormPengaduan::all();
            Log::info("Data pengaduan berhasil diambil", [
                "time" => now()->toDateTimeString()
            ]);
            return $pengaduan;
        } catch (\Throwable $th) {
            Log::error("Gagal ambil data pengaduan", [
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
            $form = FormPengaduan::findOrFail($id);
            $result = $form->update($data);

            if($result){
                Log::info('Data form pengaduan berhasil diupdate', [
                    'time' => now()->toDateTimeString()
                ]);
                
                 // Catat aktivitas
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'update',
                    'deskripsi_aktivitas' => 'Mengubah status data form pengaduan ('.$data["status"].")",
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);

            }else{
                Log::warning('Data form pengaduan gagal diupdate (tidak ada perubahan di database)', [
                    'time' => now()->toDateTimeString()
                ]);
            }
            return $result;
           
        }catch (ModelNotFoundException $e){
            Log::error("Data form pengaduan tidak ditemukan untuk diupdate", [
                "id_form" => $id,
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        }catch (\Throwable $th) {
            Log::error("Gagal update data form pengaduan", [
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
            $form = FormPengaduan::findOrFail($id);

            if ($form->path_file_bukti && Storage::disk('public')->exists($form->path_file_bukti)) {
                Storage::disk('public')->delete($form->path_file_bukti);
            }

            $form->delete();
            Log::info("Data pengaduan berhasil dihapus", [
                "time" => now()->toDateTimeString()
            ]);

            // Catat aktivitas
            AktivitasTerbaru::create([
                'username' => $username,
                'jenis_aktivitas' => 'delete',
                'deskripsi_aktivitas' => 'Menghapus data pengaduan',
                'waktu_aktivitas' => Carbon::now()->toDateTimeString()
            ]);
            return true;
        }catch (ModelNotFoundException $e){
            Log::error("Data pengaduan tidak ditemukan untuk dihapus", [
                "id" => $id,
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Gagal menghapus data pengaduan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
}
?>
