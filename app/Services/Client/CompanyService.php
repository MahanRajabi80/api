<?php

namespace App\Services\Client;

use App\Http\Requests\StoreCompanyRequest;
use App\Models\Company;
use App\Traits\ApiResponse;
use Illuminate\Support\Str;

class CompanyService
{
    use ApiResponse;

    public function getCompanies()
    {
        $companies = Company::orderBy('updated_at', 'DESC')
            ->orderBy('is_famous', 'DESC')
            ->orderBy('total_review', 'DESC')
            ->orderBy('total_interview', 'DESC')
            ->paginate(10)
            ->through(function ($company) {
                $company->description = Str::limit(strip_tags($company->description), 160);
                return $company;
            });

        return $this->okResponse($companies);
    }

    public function getCompany(string|int $slugOrID)
    {
        $company = is_numeric($slugOrID)
            ? Company::where('id', $slugOrID)->first()
            : Company::where('slug', $slugOrID)->first();

        if (!$company) {
            return $this->notFoundResponse('', 'این شرکت وجود ندارد.');
        }

        return $this->okResponse($company);
    }

    public function storeCompany(StoreCompanyRequest $request)
    {
        $payload = $request->only(['name', 'description', 'site']);

        if (empty($payload['site'])) {
            $payload['slug'] = Str::slug($payload['name'], '-');
        }

        $company = Company::create($payload);

        return $this->successResponse($company, 201);
    }
}
