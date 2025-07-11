<?php 
namespace App\Services\Implementation;

use App\Models\DokumenPublik;
use App\Services\DokumenServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class DokumenPublikImpl implements DokumenServiceInterface
{
    public function getData(){
        try {
            Log::info("Semua dokumen publik berhasil diambil", [
                "time" => now()->toDateTimeString()
            ]);
            return DokumenPublik::all();
        }catch (\Throwable $th) {
            Log::error("Gagal ambil dokumen publik", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
    
    public function getDataByTahun(int $tahun,string $kategori){
        try {
            $data = DokumenPublik::where('kategori_dokumen',$kategori)
                                -> where('tahun_dokumen',$tahun)
                                -> firstOrFail();
            Log::info("Dokumen publik berhasil diambil", [
                "time" => now()->toDateTimeString()
            ]);
            return $data;
        }catch(ModelNotFoundException $e){
            Log::error("Dokumen publik gagal diambil", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        }
         catch (\Throwable $th) {
            Log::error("Gagal ambil dokumen publik", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function getDataByKategori(string $kategori){
        try {
            $result = DokumenPublik::where('kategori_dokumen',$kategori)->firstOrFail();

            Log::info("Dokumen publik berhasil diambil", [
                "time" => now()->toDateTimeString()
            ]);
            return $result;
        }catch(ModelNotFoundException $e){
            Log::error("Dokumen publik gagal diambil", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Gagal ambil dokumen publik", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function createData(array $data){
        try {
            $result = DokumenPublik::create($data);
            Log::info("Dokumen publik berhasil ditambahkan", [
                "time" => now()->toDateTimeString()
            ]);
            return $result ;
        }catch (\Throwable $th) {
            Log::error("Gagal tambah dokumen publik", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function updateData($id, array $data)
    {
        try {
            $dokumen = DokumenPublik::findOrFail($id);
            $result = $dokumen->update($data);
    
            if ($result) {
                Log::info("Dokumen publik berhasil diupdate", [
                    "time" => now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Dokumen publik gagal diupdate (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
    
            return $result;
        } catch (ModelNotFoundException $e) {
            Log::error("Dokumen publik tidak ditemukan saat update", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Gagal update dokumen publik", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
    

    public function deleteData($id)
    {
        try {
            $dokumen = DokumenPublik::findOrFail($id);
            $result = $dokumen->delete();
    
            if ($result) {
                Log::info("Dokumen publik berhasil dihapus", [
                    "time" => now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Dokumen publik gagal dihapus (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
    
            return $result;
        } catch (ModelNotFoundException $e) {
            Log::error("Dokumen publik tidak ditemukan saat hapus", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Gagal hapus dokumen publik", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
    

}
?>
