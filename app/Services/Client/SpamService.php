<?php

namespace App\Services\Client;

use App\Models\Log;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SpamService
{
    use ApiResponse;

    public function isCheck($request, $contentType, $contentID): bool
    {
        $ip = $request->ip();
        $deviceId = $request->header('hash');
        $subDays = $contentType === 'COMMENT' ? 1 : 2;

        // Rate limit per IP address
        $ipLogsCount = $this->getLogsCountByCriteria($ip, $contentType, $subDays);
        if ($contentType == 'REVIEW' && $ipLogsCount > 3) {
            return true;
        }

        // Rate limit per Device ID
        $deviceLogsCount = $this->getLogsCountByCriteria($deviceId, $contentType, $subDays, true);
        if ($deviceLogsCount > 5) { // Adjust the limit as necessary
            return true;
        }

        // Record the log
        $this->recordLog($ip, $deviceId, $contentType, $contentID);

        return false;
    }

    private function getLogsCountByCriteria($criteria, $contentType, $subDays, $isDevice = false): int
    {
        $query = Log::where('content_type', $contentType)
            ->where('created_at', '>=', Carbon::now()->subDays($subDays));

        $field = $isDevice ? 'device_id' : 'ip_address';
        $query->where($field, $criteria);

        return $query->count();
    }

    private function recordLog($ip, $deviceId, $contentType, $contentID): void
    {
        DB::beginTransaction();
        try {
            Log::create([
                'ip_address' => $ip,
                'device_id' => $deviceId,
                'content_type' => $contentType,
                'content_id' => $contentID,
                'created_at' => Carbon::now()
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // Log error or handle appropriately
        }
    }
}
