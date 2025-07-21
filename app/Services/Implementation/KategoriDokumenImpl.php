<?php 
namespace App\Services\Implementation;

use App\Models\AktivitasTerbaru;
use App\Models\KategoriDokumen;
use App\Services\DataServiceInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class KategoriDokumenImpl implements DataServiceInterface
{
    public function getData(){
        
    }
    public function createData(array $data, string $username)
    {
        try {
            $result = KategoriDokumen::create($data);
            Log::info("Data kategori dokumen berhasil ditambahkan", [
                "time" => now()->toDateTimeString()
            ]);
            // Catat aktivitas
            AktivitasTerbaru::create([
                'username' => $username,
                'jenis_aktivitas' => 'create',
                'deskripsi_aktivitas' => 'Menambahkan Kategori Dokumen',
                'waktu_aktivitas' => Carbon::now()->toDateTimeString()
            ]);
            return $result;
        } catch (\Throwable $th) {
            Log::error("Data kategori dokumen gagal ditambahkan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function updateData($id, array $data, string $username){
        try {
            $dataKategori = KategoriDokumen::findOrFail($id);
            $result = $dataKategori->update($data);
            if ($result) {
                Log::info("Data kategori dokumen berhasil diupdate", [
                    "time" => now()->toDateTimeString()
                ]);
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'update',
                    'deskripsi_aktivitas' => 'Mengubah Kategori Dokumen',
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data kategori dokumen gagal diupdate", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        }catch(ModelNotFoundException $e){
            Log::error("Data kategori dokumen tidak ditemukan", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Data kategori dokumen gagal diupdate", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }

    }

    public function deleteData($id, string $username){
        try {
            $dataKategori = KategoriDokumen::findOrFail($id);
            $result = $dataKategori->delete();
            if ($result) {
                Log::info("Data kategori dokumen berhasil dihapus", [
                    "time" => now()->toDateTimeString()
                ]);
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'delete',
                    'deskripsi_aktivitas' => 'Menghapus Kategori Dokumen',
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data kategori dokumen gagal dihapus", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        }catch(ModelNotFoundException $e){
            Log::error("Data kategori dokumen tidak ditemukan", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Data kategori dokumen gagal dihapus", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }

    }
}

?>