<?php
namespace App\Services\Implementation;

use App\Models\MaklumatPelayanan;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class MaklumatPelayananServiceImpl implements DataServiceInterface
{
    public function getData()
    {
        try {
            $data = MaklumatPelayanan::all();
            Log::info("Data maklumat pelayanan berhasil diambil", [
                "count" => $data->count(),
                "time" => now()->toDateTimeString()
            ]);
            return $data;
        } catch (\Throwable $th) {
            Log::error("Data maklumat pelayanan gagal diambil", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function createData(array $data)
    {
        try {
            $result = MaklumatPelayanan::create($data);
            Log::info("Data maklumat pelayanan berhasil ditambahkan", [
                "time" => now()->toDateTimeString()
            ]);
            return $result;
        } catch (\Throwable $th) {
            Log::error("Gagal menambahkan data maklumat pelayanan", [
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
            $result = MaklumatPelayanan::findOrFail($id);

            $data = $result->update($data);
            if ($data) {
                Log::info("Data maklumat pelayanan berhasil diupdate", [
                    "time" => now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data maklumat pelayanan gagal diupdate (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        }catch (ModelNotFoundException $e){
            Log::error("Data maklumat pelayanan gagal diupdate", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Gagal update data maklumat pelayanan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function deleteData( $id)
    {
        try {
            $data = MaklumatPelayanan::findOrFail($id);
            $result = $data->delete();
            if ($result) {
                Log::info("Data maklumat pelayanan berhasil dihapus", [
                    "time" => now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data maklumat pelayanan gagal dihapus (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        } catch (ModelNotFoundException $e) {
            Log::error("Data maklumat pelayanan gagal dihapus", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Gagal hapus data maklumat pelayanan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now()->toDateTimeString(),
            ]);
            throw $th;
        }
    }
}
?>
