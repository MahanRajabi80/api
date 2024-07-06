<?php

namespace App\Services\Client;

use App\Models\Reason;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ReasonService
{
    use ApiResponse;


    public function getReasons(Request $request)
    {
        $reasonsQuery = Reason::query();

        if ($request->filled('type')) {
            $reasonsQuery->where('reason_type', $request->type);
        }

        $reasons = $reasonsQuery->get();

        return $this->successResponse($reasons);
    }
}
