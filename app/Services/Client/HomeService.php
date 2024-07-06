<?php

namespace App\Services\Client;

use App\Models\Company;
use App\Models\Review;
use App\Traits\ApiResponse;
use Carbon\Carbon;

class HomeService
{
    use ApiResponse;

    const COUNT = 20;

    public function getHome()
    {
        $currentDate = Carbon::now();
        $currentMonth = $currentDate->day >= 1 && $currentDate->day <= 7
            ? $currentDate->subDays(30)
            : $currentDate->firstOfMonth();

        $reviews = Review::where('created_at', '>=', $currentMonth)
            ->where('status', 'PUBLISH')
            ->get()
            ->groupBy('company_id');

        $topCompanies = [];
        $worstCompanies = [];

        foreach ($reviews as $companyId => $items) {
            $avgRate = $items->avg('rate');

            if ($avgRate >= 3) {
                $topCompanies[] = $companyId;
            } else {
                $worstCompanies[] = $companyId;
            }
        }

        $topCompanies = array_slice(array_unique($topCompanies), 0, self::COUNT);
        $worstCompanies = array_slice(array_unique($worstCompanies), 0, self::COUNT);

        $data['top'] = Company::select(['id', 'name', 'slug'])->whereIn('id', $topCompanies)->get();
        $data['worst'] = Company::select(['id', 'name', 'slug'])->whereIn('id', $worstCompanies)->get();

        return $this->okResponse($data);
    }
}
