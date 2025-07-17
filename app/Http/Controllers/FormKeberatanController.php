<?php

namespace App\Http\Controllers;

use App\Http\Requests\formKeberatanRequest\createFormKeberatanRequest;
use App\Http\Requests\FormKeberatanRequest\updateRequest;
use App\Services\FormServiceInterface;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FormKeberatanController extends Controller
{
    private FormServiceInterface $form;

    public function __construct(FormServiceInterface $form)
    {
        $this->form = $form;
    }
    public function index(){
        try {
            $data = $this->form->getForm();

            return response()->json([
                'status' => 200,
                'message' => 'Data semua form keberatan berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function store(createFormKeberatanRequest $request){
        try {
            $validated = $request->validated();

            $data = $this->form->createForm($validated);
            
            return response()->json([
                'status' => 200,
                'message' => 'Data form keberatan berhasil ditambahkan',
                'data' => $data
            ], 200);
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function update(updateRequest $request, $id)
    {
        try{
            $validated = $request->validated();
            $user = $request->user();
            $username = $user ? $user->username : null;

            $result = $this->form->updateForm($id, $validated, $username);

            if(!$result){
                return response()->json([
                    'status' => 404,
                    'message' => 'Data form pengajuan keberatan tidak ditemukan'
                ], 404);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Data form pengajuan keberatan berhasil diupdate',
                'data' => $result
            ], 200);
           
        }catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function destroy($id){
        try {
            $user = Auth::user();
            $username = $user ? $user->username : null;
           $result = $this->form->deleteForm($id, $username);

            if (!$result) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data form keberatan tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data form keberatan berhasil dihapus'
            ], 200);
        }catch(\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}
