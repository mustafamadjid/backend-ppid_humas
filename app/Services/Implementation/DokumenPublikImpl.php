<?php 
namespace App\Services\Implementation;

use App\Models\DokumenPublik;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class DokumenPublikImpl implements DataServiceInterface
{
    public function getData(){
        try {
            Log::info("Semua dokumen publik berhasil diambil");
            return DokumenPublik::all();
        }catch (\Throwable $th) {
            Log::error("Gagal ambil dokumen publik", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }

    public function createData(array $data){
        try {
            Log::info("Dokumen publik berhasil ditambahkan");
            return DokumenPublik::create($data);
        }catch (\Throwable $th) {
            Log::error("Gagal tambah dokumen publik", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }

    public function updateData(Model $dokumen, array $data){
            try {
                Log::info("Dokumen publik berhasil diupdate");
                return $dokumen->update($data);
            } catch (\Throwable $th) {
                Log::error("Gagal update dokumen publik", [
                    'error' => $th->getMessage(),
                    'trace' => $th->getTraceAsString(),
                ]);
                throw $th;
            }
    }

    public function deleteData(Model $dokumen){
        try {
            Log::info("Dokumen publik berhasil dihapus");
            return $dokumen->delete();
        } catch (\Throwable $th) {
            Log::error("Gagal hapus dokumen publik", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }
}


?>