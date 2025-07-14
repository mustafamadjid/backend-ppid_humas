<?php
namespace App\Services\Implementation;

use App\Models\JabatanOrganisasi;
use App\Models\AktivitasTerbaru;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class JabatanOrganisasiServiceImpl implements DataServiceInterface
{
    public function getData()
    {
        try {
            $data = JabatanOrganisasi::all();
            Log::info("Data jabatan organisasi berhasil diambil", [
                "count" => $data->count(),
                "time" => now()->toDateTimeString()
            ]);
            return $data;
        } catch (\Throwable $th) {
            Log::error("Data jabatan organisasi gagal diambil", [
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
            $result = JabatanOrganisasi::create($data);
            Log::info("Data jabatan organisasi berhasil ditambahkan", [
                "time" => now()->toDateTimeString()
            ]);
            // Catat aktivitas
            AktivitasTerbaru::create([
                'username' => $username,
                'jenis_aktivitas' => 'create',
                'deskripsi_aktivitas' => 'Menambahkan Jabatan Organisasi',
                'waktu_aktivitas' => Carbon::now()->toDateTimeString()
            ]);
            return $result;
        } catch (\Throwable $th) {
            Log::error("Data jabatan organisasi gagal ditambahkan", [
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
            $dataJabatan = JabatanOrganisasi::findOrFail($id);
            $result = $dataJabatan->update($data);
            if ($result) {
                Log::info("Data jabatan organisasi berhasil diupdate", [
                    "time" => now()->toDateTimeString()
                ]);
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'update',
                    'deskripsi_aktivitas' => 'Mengubah Jabatan Organisasi',
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data jabatan organisasi gagal diupdate", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        } catch (ModelNotFoundException $e) {
            Log::error("Data jabatan organisasi gagal diupdate", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Data jabatan organisasi gagal diupdate", [
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
            $dataJabatan = JabatanOrganisasi::findOrFail($id);
            $result = $dataJabatan->delete();

            if ($result) {
                Log::info("Data jabatan organisasi berhasil dihapus", [
                    "time" => now()->toDateTimeString()
                ]);
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'delete',
                    'deskripsi_aktivitas' => 'Menghapus Jabatan Organisasi',
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data jabatan organisasi gagal dihapus", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        } catch (ModelNotFoundException $e) {
            Log::error("Data jabatan organisasi gagal dihapus", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Data jabatan organisasi gagal dihapus", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
}
?>
