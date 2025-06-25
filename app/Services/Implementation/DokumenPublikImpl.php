<?php 
namespace App\Services\Implementation;

use App\Models\DokumenPublik;
use App\Services\DokumenPublikInterface;
use Illuminate\Support\Facades\Log;

class DokumenPublikImpl implements DokumenPublikInterface
{
    public function getDokumenPublik(){
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

    public function createDokumenPublik(array $data){
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

    public function updateDokumenPublik(DokumenPublik $dokumen, array $data){
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

    public function deleteDokumenPublik(DokumenPublik $dokumen){
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