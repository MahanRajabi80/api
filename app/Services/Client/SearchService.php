<?php

namespace App\Services\Client;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreDeviceRequest;
use App\Models\Company;
use App\Models\Review;
use App\Traits\ApiResponse;

class SearchService
{
    use ApiResponse;

    public function searchAll(SearchRequest $request)
    {
        $q = $request->get('q');
        $site = $request->get('site');
        $isCompany = $request->has('company');

        $companyRows = $this->searchCompaniesArray($q, $site);
        $reviewRows = $this->searchReviews($q);


        if ($isCompany) {
            return $this->okResponse($companyRows);
        }

        return $this->okResponse(array_merge($reviewRows, $companyRows));
    }

    public function searchCompanies(SearchRequest $request)
    {
        $q = $request->get('q');

        $query = Company::select(['id', 'slug', 'name']);
        if($request->has('q')) {
            $query->where('name', 'like', '%' . $q . '%')->orWhere('slug', 'like', '%' . $q . '%');
        }
        $query->orderBy('total_review', 'DESC')->orderBy('total_interview', 'DESC')->orderBy('is_famous', 'DESC');


        $rows = $query->limit(50)->get();


        return $this->okResponse($rows);
    }

    /**
     * @param SearchRequest $request
     * @return array
     */
    private function searchCompaniesArray(string $q, string|null $site)
    {
        $queryCompany = Company::select(['id', 'slug', 'name']);
        if ($q) {
            $queryCompany->where('name', 'like', '%' . $q . '%')->orWhere('slug', 'like', '%' . $q . '%');
        }
        if ($site) {
            $queryCompany->where('site', 'like', '%' . $site . '%');
        }
        $queryCompany->orderBy('total_review', 'DESC')->orderBy('total_interview', 'DESC')->orderBy('is_famous', 'DESC');
        $companyRows = $queryCompany->limit(50)->get();
        $arrayCompany = $companyRows->toArray();
        for ($i = 0; $i < count($arrayCompany); $i++) {
            $arrayCompany[$i]['type'] = 'COMPANY';
        }

        return $arrayCompany;
    }

    private function searchReviews(string $q) {
        $queryReview = Review::select(['id', 'review_type', 'title'])->where('status', 'PUBLISH');
        if($q) {
            $queryReview
                ->where('title', 'like', '%' . $q . '%')
                ->orWhere('job_title', 'like', '%' . $q . '%');;
        }
        $arrayReview = $queryReview->limit(50)->get()->toArray();
        for ($i = 0; $i < count($arrayReview); $i++) {
            $arrayReview[$i]['type'] = $arrayReview[$i]['review_type'];
            unset($arrayReview[$i]['review_type']);
        }

        return $arrayReview;
    }
}
