<?php

namespace App\Http\Controllers\Client;

use App\Services\Client\ReasonService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
    use ApiResponse;

    private ReasonService $reasonService;

    public function __construct(ReasonService $reasonService)
    {
        $this->reasonService = $reasonService;
    }

    public function index(Request $request)
    {
        return $this->reasonService->getReasons($request);
    }
}
