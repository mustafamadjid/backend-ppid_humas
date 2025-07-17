<?php
namespace App\Services\Implementation;

use App\Models\DeskripsiHalamanDokumen;
use App\Models\AktivitasTerbaru;
use App\Services\DeskripsiHalamanDokumenInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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
                "kategori" => $kategori,
                "time" => now()->toDateTimeString()
            ]);
            return $data;
        } catch (ModelNotFoundException $e) {
            Log::error("Data deskripsi halaman dokumen gagal diambil", [
                'kategori' => $kategori,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Data deskripsi halaman dokumen gagal diambil", [
                'kategori' => $kategori,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    // Tambahkan $username pada setiap aksi perubahan data
    public function createData(array $data, string $username)
    {
        try {
            $result = DeskripsiHalamanDokumen::create($data);
            Log::info("Data deskripsi halaman dokumen berhasil ditambahkan", [
                "username" => $username,
                "inserted_id" => $result->id ?? null,
                "time" => now()->toDateTimeString()
            ]);

            // Tambah ke aktivitas terbaru
            AktivitasTerbaru::create([
                'username' => $username,
                'jenis_aktivitas' => 'create',
                'deskripsi_aktivitas' => 'Menambahkan Deskripsi Halaman Dokumen',
                'waktu_aktivitas' => Carbon::now()->toDateTimeString()
            ]);
            return $result;
        } catch (\Throwable $th) {
            Log::error("Data deskripsi halaman dokumen gagal ditambahkan", [
                "username" => $username,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function updateData( $id, array $data, string $username)
    {
        try {
            $dataDesc = DeskripsiHalamanDokumen::findOrFail($id);
            $result = $dataDesc->update($data);

            if ($result) {
                Log::info("Data deskripsi halaman dokumen berhasil diupdate", [
                    "username" => $username,
                    "id" => $id,
                    "time" => now()->toDateTimeString()
                ]);
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'update',
                    'deskripsi_aktivitas' => 'Mengubah Deskripsi Halaman Dokumen',
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data deskripsi halaman dokumen gagal diupdate (tidak ada perubahan di database)", [
                    "username" => $username,
                    "id" => $id,
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        } catch (ModelNotFoundException $e) {
            Log::error("Data deskripsi halaman dokumen gagal diupdate", [
                "username" => $username,
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Data deskripsi halaman dokumen gagal diupdate", [
                "username" => $username,
                'id' => $id,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function deleteData( $id, string $username)
    {
        try {
            $dataDesc = DeskripsiHalamanDokumen::findOrFail($id);
            $result = $dataDesc->delete();

            if ($result) {
                Log::info("Data deskripsi halaman dokumen berhasil dihapus", [
                    "username" => $username,
                    "id" => $id,
                    "time" => now()->toDateTimeString()
                ]);
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'delete',
                    'deskripsi_aktivitas' => 'Menghapus Deskripsi Halaman Dokumen',
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data deskripsi halaman dokumen gagal dihapus (tidak ada perubahan di database)", [
                    "username" => $username,
                    "id" => $id,
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        } catch (ModelNotFoundException $e) {
            Log::error("Data deskripsi halaman dokumen gagal dihapus", [
                "username" => $username,
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Data deskripsi halaman dokumen gagal dihapus", [
                "username" => $username,
                'id' => $id,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
}
?>
