<?php

namespace App\Http\Controllers\Client;


use App\Models\Company;
use App\Models\Review;
use Watson\Sitemap\Facades\Sitemap;


class SitemapsController extends Controller
{
    const RECORDS_PER_BATCH = 5000;

    public function index()
    {
        $lastReview = Review::where('status', 'PUBLISH')->first();
        $countCompanies = Company::where('status', 'PUBLISH')->count();

//        for ($i = 0; $i < ceil($countCompanies / self::RECORDS_PER_BATCH); $i++) {
//            Sitemap::addSitemap('https://api.tajrobe.wiki/sitemap/companies/' . $i + 1);
//        }

//        for ($i = 0; $i < ceil($countReviews / self::RECORDS_PER_BATCH); $i++) {
//            Sitemap::addSitemap('https://api.tajrobe.wiki/sitemap/reviews/' . $i + 1);
//        }

        Sitemap::addTag('https://tajrobe.wiki', $lastReview->updated_at, 'hourly', '1.0');
        Sitemap::addTag('https://tajrobe.wiki/company', $lastReview->updated_at, 'hourly', '1.0');

        return Sitemap::render();
    }

    public function reviews($page = 0)
    {
        $reviews = Review::where('status', 'PUBLISH')->forPage($page, self::RECORDS_PER_BATCH)->get();
        foreach ($reviews as $review) {
            Sitemap::addTag('https://tajrobe.wiki/review/' . $review->id, $review->updated_at, 'weekly', '0.8');
        }

        return Sitemap::render();
    }

    public function companies($page = 0)
    {
        $companies = Company::where('status', 'PUBLISH')->forPage($page, self::RECORDS_PER_BATCH)->get();
        foreach ($companies as $company) {
            $slug = '';
            if ($company->slug) {
                $slug = $company->slug;
            } else {
                $slug = $company->id;
            }
            Sitemap::addTag('https://tajrobe.wiki/company/' . $slug, $company->updated_at, 'weekly', '0.8');
        }

        return Sitemap::render();
    }
}
