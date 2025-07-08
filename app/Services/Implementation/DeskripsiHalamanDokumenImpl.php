<?php
namespace App\Services\Implementation;

use App\Models\DeskripsiHalamanDokumen;

use App\Services\DeskripsiHalamanDokumenInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class DeskripsiHalamanDokumenImpl implements DeskripsiHalamanDokumenInterface
{
    public function getData()
    {
        try {
            $data = DeskripsiHalamanDokumen::all();
            Log::info("Data deskripsi halaman dokumen berhasil diambil", [
                "count" => $data->count(),
                "time" => now()->toDateTimeString()
            ]);
            return $data;
        } catch (\Throwable $th) {
            Log::error("Data deskripsi halaman dokumen gagal diambil", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function getDataByKategori(string $kategori)
    {
        try {
            $data = DeskripsiHalamanDokumen::where('kategori_dokumen', $kategori)->firstOrFail();
            Log::info("Data deskripsi halaman dokumen berhasil diambil", [
                "time" => now()->toDateTimeString()
            ]);
            return $data;
        }catch(ModelNotFoundException $e){
            Log::error("Data deskripsi halaman dokumen gagal diambil", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        }catch (\Throwable $th) {
           Log::error("Data deskripsi halaman dokumen gagal diambil", [
               'error' => $th->getMessage(),
               'trace' => $th->getTraceAsString(),
               "time" => now()->toDateTimeString()
           ]);
        }
    }

    public function createData(array $data)
    {
        try {
            $result = DeskripsiHalamanDokumen::create($data);
            Log::info("Data deskripsi halaman dokumen berhasil ditambahkan", [
                "time" => now()->toDateTimeString()
            ]);
            return $result;
        } catch (\Throwable $th) {
            Log::error("Data deskripsi halaman dokumen gagal ditambahkan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
    public function updateData(int $id, array $data)
    {
        try {
            $dataDesc = DeskripsiHalamanDokumen::findOrFail($id);

            $result = $dataDesc->update($data);

            if ($result) {
                Log::info("Data deskripsi halaman dokumen berhasil diupdate", [
                    "time" => now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data deskripsi halaman dokumen gagal diupdate (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        }catch(ModelNotFoundException $e){
            Log::error("Data deskripsi halaman dokumen gagal diupdate", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        }
        catch (\Throwable $th) {
            Log::error("Data deskripsi halaman dokumen gagal diupdate", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function deleteData(int $id)
    {
        try {
            $dataDesc = DeskripsiHalamanDokumen::findOrFail($id);

            $result = $dataDesc->delete();
            if ($result) {
                Log::info("Data deskripsi halaman dokumen berhasil dihapus", [
                    "time" => now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data deskripsi halaman dokumen gagal dihapus (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        } catch(ModelNotFoundException $e){
            Log::error("Data deskripsi halaman dokumen gagal dihapus", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } 
        catch (\Throwable $th) {
            Log::error("Data deskripsi halaman dokumen gagal dihapus", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

}

?>