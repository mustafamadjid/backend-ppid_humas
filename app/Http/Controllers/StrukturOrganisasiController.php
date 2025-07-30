<?php

namespace App\Http\Controllers;

use App\Models\JabatanOrganisasi;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class StrukturOrganisasiController extends Controller
{
    public function getStruktur()
{
    try {
        
        $jabatan = JabatanOrganisasi::with(['bawahan', 'pegawai'])->get();

        
        $tree = $this->buildTree($jabatan);

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $tree
        ]);
    } catch (\Throwable $th) {
        return response()->json([
            'status' => 500,
            'message' => 'Internal server error',
            'error' => $th->getMessage()
        ]);
    }
}

    private function buildTree($jabatanList, $parentId = null)
    {
        $result = [];
        foreach ($jabatanList as $jabatan) {
            if ($jabatan->id_atasan == $parentId) {
                // Rekursif ambil children
                $jabatanArr = $jabatan->toArray();
                $jabatanArr['bawahan'] = $this->buildTree($jabatanList, $jabatan->id_jabatan);
                $result[] = $jabatanArr;
            }
        }
        return $result;
    }
}
