<?php
namespace App\Services\Implementation;

use App\Models\Visitor;
use App\Services\VisitorServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class VisitorServiceImpl implements VisitorServiceInterface
{
    public function getTotalVisitor()
    {
        try {
            $data = Visitor::count();
            Log::info("Total visitor berhasil diambil", [
                "count" => $data,
                "time" => now()->toDateTimeString()
            ]);
            return $data;
        } catch (\Throwable $th) {
            Log::error("Gagal ambil total visitor", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function countVisitor(string $ip)
    {
        try {
            $result = Visitor::create([
                'ip_address' => $ip
            ]);
            Log::info("Visitor berhasil dihitung", [
                "data" => $result,
                "time" => now()->toDateTimeString()
            ]);
            return $result;
        } catch (\Throwable $th) {
            Log::error("Gagal hitung visitor", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function countVisitorToday()
    {
        try {
            $data = Visitor::whereDate('created_at',Carbon::today())->count();
            Log::info("Total visitor hari ini berhasil diambil", [
                "count" => $data,
                "time" => now()->toDateTimeString()
            ]);
            return $data;
        } catch (\Throwable $th) {
            Log::error("Gagal ambil total visitor hari ini", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
}
?>