<?php 
namespace App\Services\Implementation;

use App\Models\JabatanAssginments;
use App\Models\Pegawai;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PegawaiServiceImpl implements DataServiceInterface
{
    public function getData()
    {
        try {
            $data = Pegawai::all();
            Log::info("Data pegawai berhasil diambil", [
                "time" => now()->toDateTimeString()
            ]);
            return $data;
        } catch (\Throwable $th) {
            Log::error("Data pegawai gagal diambil", [
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
            $pegawai = Pegawai::create($data);

            $idJabatan = $data['id_jabatan'];
            $idPegawai = $pegawai->id_pegawai;

            $jabatanAssign = JabatanAssginments::create([
                'id_jabatan' => $idJabatan,
                'id_pegawai' => $idPegawai
            ]);

            Log::info("Data pegawai berhasil ditambahkan", [
                "time" => now()->toDateTimeString()
            ]);

            return [$pegawai, $jabatanAssign];
           

        } catch (\Throwable $th) {
            Log::error("Data pegawai gagal ditambahkan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
    public function updateData( $id, array $data)
    {
        try{
            $idPegawai = Pegawai::findOrFail($id);

            if(isset($data['id_jabatan'])){
                $jabatanAssign = JabatanAssginments::where('id_pegawai', $id)->first();

                if(!$jabatanAssign){
                    return response()->json([
                        'status' => 404,
                        'message' => 'Data jabatan tidak ditemukan',
                    ],404);
                }

                $jabatanAssign->id_jabatan = $data['id_jabatan'];
                $jabatanAssign->save();
            }

            $result = $idPegawai->update($data);

            if($result){
                Log::info("Data pegawai berhasil diupdate", [
                    "time" => now()->toDateTimeString()
                ]);
            }else{
                Log::warning("Data pegawai gagal diupdate (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        }catch(ModelNotFoundException $th){
            Log::error("Data pegawai gagal diupdate", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        }catch (\Throwable $th) {
            Log::error("Data pegawai gagal diupdate", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
    public function deleteData(  $id)
    {
        try {
            $pegawai = Pegawai::findOrFail($id);

            if($pegawai->path_file_foto && Storage::disk('public')->exists($pegawai->path_file_foto)){
                Storage::disk('public')->delete($pegawai->path_file_foto);
            }

            $result = $pegawai->delete();

            if($result){
                Log::info("Data pegawai berhasil dihapus", [
                    "time" => now()->toDateTimeString()
                ]);
            }else{
                Log::warning("Data pegawai gagal dihapus (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        }catch(ModelNotFoundException $th){
            Log::error("Data pegawai gagal dihapus", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Data pegawai gagal dihapus", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
}
?>