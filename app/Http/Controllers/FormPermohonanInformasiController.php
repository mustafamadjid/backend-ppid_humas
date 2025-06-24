<?php

namespace App\Http\Controllers;

use App\Models\FormPermohonanInformasi;
use App\Services\FormPermohonanInformasiInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FormPermohonanInformasiController extends Controller
{
    private FormPermohonanInformasiInterface $form;
    public function __construct(FormPermohonanInformasiInterface $form) {
        $this->form = $form;
    }
    public function index()
    {
        try {
            $data = $this->form->getAllFormPermohonanInformasi();
            return response()->json([
                'status' => 200,
                'message' => 'Data semua form permohonan informasi berhasil diambil',
                'data' => $data
            ]);
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'nama_pemohon' => [
                    'required',
                    'string',
                    'max:300',
                ],
                'no_ktp_pemohon' => [
                    'required',
                    'string',
                    'max:16',
                ],
                'alamat_pemohon' => [
                    'required',
                    'string',
                    
                ],
                'no_telp_pemohon' => [
                    'required',
                    'string',
                    'max:15',
                ],
                'email_pemohon' => [
                    'required',
                    'string',
                    'email',
                    
                ],
                'kebutuhan_informasi_pemohon' => [
                    'required',
                    'string',
                    
                ],
                'alasan_permintaan' => [
                    'required',
                    'string',
                    
                ],
                'nama_pengguna' => [
                    'required',
                    'string',
                    'max:300',
                ],
                'no_ktp_pengguna' => [
                    'required',
                    'string',
                    'max:16',
                ],
                'alamat_pengguna' => [
                    'required',
                    'string',
                    
                ],
                'no_telp_pengguna' => [
                    'required',
                    'string',
                    'max:15',
                ],
                'email_pengguna' => [
                    'required',
                    'string',
                    'email',
                    
                ],
                'kebutuhan_informasi_pengguna' => [
                    'required',
                    'string',
                    
                ],
                'alasan_penggunaan' => [
                    'required',
                    'string',
                ],
                'cara_perolehan_informasi' => [
                    'required',
                    'string',
                ],
                'format_informasi' => [
                    'required',
                    'string',
                ],
                'cara_pengiriman_informasi' => [
                    'required',
                    'string',
                ],
            ]);

            if($validated->fails()){
                return response()->json([
                    'status' => 400,
                    'message' => 'Data form permohonan informasi gagal disimpan',
                    'errors' => $validated->errors()
                ],400);
            }

            $data = $this->form->createFormPermohonanInformasi($validated->validated());

            return response()->json([
                'status' => 200,
                'message' => 'Data form permohonan informasi berhasil disimpan',
                'data' => $data
            ]);
            
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $formData = FormPermohonanInformasi::findOrFail($id);
            $this->form->deleteFormPermohonanInformasi($formData);

            return response()->json([
                'status' => 200,
                'message' => 'Data form permohonan informasi berhasil dihapus'
            ]);
        }catch(ModelNotFoundException $e){
            return response()->json([
                'status' => 404,
                'message' => 'Data form permohonan informasi tidak ditemukan'
            ], 404);
        }
        catch(\Throwable $e){
            throw new HttpException(500, $e->getMessage());
        }
    }
}
