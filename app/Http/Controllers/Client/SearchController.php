<?php

namespace App\Http\Controllers\Client;


use App\Http\Requests\SearchRequest;
use App\Services\Client\CommentService;
use App\Services\Client\SearchService;
use App\Traits\ApiResponse;


class SearchController extends Controller
{
    use ApiResponse;

    private SearchService $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function searchAll(SearchRequest $request)
    {
        return $this->searchService->searchAll($request);
    }

    public function searchCompanies(SearchRequest $request)
    {
        return $this->searchService->searchCompanies($request);
    }
}
