<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\StoreReportRequest;
use App\Services\Client\ReportService;
use App\Traits\ApiResponse;

class ReportController extends Controller
{
    use ApiResponse;

    private ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
        $this->middleware('doNotCacheResponse', ['only' => ['store']]);
        $this->middleware('throttle:10,1440', ['only' => ['store']]);
    }

    public function store(StoreReportRequest $request)
    {
        return $this->reportService->storeReport($request);
    }

}
