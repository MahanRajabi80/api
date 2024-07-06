<?php

namespace App\Http\Controllers\Client;

use App\Services\Client\CompanyService;
use App\Services\Client\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function getHome()
    {
        return $this->homeService->getHome();
    }
}
