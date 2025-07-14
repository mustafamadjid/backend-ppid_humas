<?php 
namespace App\Services\Implementation;

use App\Models\SematanAplikasi;
use App\Models\AktivitasTerbaru;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SematanAplikasiImpl implements DataServiceInterface
{
   public function getData()
   {
       try {
           $data = SematanAplikasi::all();
           Log::info("Data sematan aplikasi berhasil diambil", [
               "time" => now()->toDateTimeString()
           ]);
           return $data;
       } catch (\Throwable $th) {
           Log::error("Data sematan aplikasi gagal diambil", [
               'error' => $th->getMessage(),
               'trace' => $th->getTraceAsString(),
               "time" => now()->toDateTimeString()
           ]);
           throw $th;
       }
   }

   public function createData(array $data, string $username)
   {
       try { 
           $result = SematanAplikasi::create($data);
           Log::info("Data sematan aplikasi berhasil ditambahkan", [
               "time" => now()->toDateTimeString()
           ]);
           // Catat aktivitas
           AktivitasTerbaru::create([
               'username' => $username,
               'jenis_aktivitas' => 'create',
               'deskripsi_aktivitas' => 'Menambahkan Sematan Aplikasi',
               'waktu_aktivitas' => Carbon::now()->toDateTimeString()
           ]);
           return $result;
       } catch (\Throwable $th) {
           Log::error("Data sematan aplikasi gagal ditambahkan", [
               'error' => $th->getMessage(),
               'trace' => $th->getTraceAsString(),
               "time" => now()->toDateTimeString()
           ]);
           throw $th;
       }
   }

   public function updateData($id, array $data, string $username)
   {
       try {
           $result = SematanAplikasi::findOrFail($id);
           $update = $result->update($data);

           if($update){
               Log::info("Data sematan aplikasi berhasil diupdate", [
                   "time" => now()->toDateTimeString()
               ]);
               AktivitasTerbaru::create([
                   'username' => $username,
                   'jenis_aktivitas' => 'update',
                   'deskripsi_aktivitas' => 'Mengubah Sematan Aplikasi',
                   'waktu_aktivitas' => Carbon::now()->toDateTimeString()
               ]);
           }else{
               Log::warning("Data sematan aplikasi gagal diupdate (tidak ada perubahan di database)", [
                   "time" => now()->toDateTimeString()
               ]);
           }
           return $update;
       } catch(ModelNotFoundException $th){
           Log::error("Data sematan aplikasi tidak ditemukan", [
               'error' => $th->getMessage(),
               'trace' => $th->getTraceAsString(),
               "time" => now()->toDateTimeString()
           ]);
           return false;
       } catch (\Throwable $th) {
           Log::error("Data sematan aplikasi gagal diupdate", [
               'error' => $th->getMessage(),
               'trace' => $th->getTraceAsString(),
               "time" => now()->toDateTimeString()
           ]);
           throw $th;
       }
   }

   public function deleteData($id, string $username)
   {
       try {
           $result = SematanAplikasi::findOrFail($id);
           $delete = $result->delete();

           if($delete){
               Log::info("Data sematan aplikasi berhasil dihapus", [
                   "time" => now()->toDateTimeString()
               ]);
               AktivitasTerbaru::create([
                   'username' => $username,
                   'jenis_aktivitas' => 'delete',
                   'deskripsi_aktivitas' => 'Menghapus Sematan Aplikasi',
                   'waktu_aktivitas' => Carbon::now()->toDateTimeString()
               ]);
           }else{
               Log::warning("Data sematan aplikasi gagal dihapus (tidak ada perubahan di database)", [
                   "time" => now()->toDateTimeString()
               ]);
           }
       
           return $delete;
       } catch(ModelNotFoundException $th){
           Log::error("Data sematan aplikasi tidak ditemukan", [
               'error' => $th->getMessage(),
               'trace' => $th->getTraceAsString(),
               "time" => now()->toDateTimeString()
           ]);
           return false;
       } catch (\Throwable $th) {
           Log::error("Data sematan aplikasi gagal dihapus", [
               'error' => $th->getMessage(),
               'trace' => $th->getTraceAsString(),
               "time" => now()->toDateTimeString()
           ]);
           throw $th;
       }
   }
}
?>
