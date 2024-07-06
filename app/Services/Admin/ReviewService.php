<?php

namespace App\Services\Admin;

use App\Http\Requests\ChangeReviewStatusRequest;
use App\Models\Company;
use App\Models\Review;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Spatie\ResponseCache\Facades\ResponseCache;

class ReviewService
{
    use ApiResponse;

    public function getReviews(Request $request)
    {
        $q = $request->input('q');
        $status = $request->input('status');

        $query = Review::with(['company' => function ($query) {
            $query->select('id', 'slug', 'name');
        }])->orderBy('id', 'DESC');

        if ($request->has('q')) {
            $query->where('title', 'like', '%' . $q . '%');
        }

        if ($request->has('status')) {
            $query->where('status', $status);
        }

        $reviews = $query->paginate(10);

        return $this->okResponse($reviews);
    }

    public function getReview(string $id)
    {
        $review = Review::with(['company' => function ($query) {
            $query->select('id', 'slug', 'name');
        }])
            ->where('id', $id)
            ->first();

        return $this->okResponse($review);
    }

    public function changeStatus(ChangeReviewStatusRequest $request, $id)
    {
        $userRole = $request->user()->role;
        $status = $request->input('status');


        $review = Review::whereId($id)->first();
//        dd($review->approved_by);
//        dd(($userRole == 'employee' && $review->approved_by != $request->user()->id));
        $companyID = $review->company_id;

        if ($review->approved_by != null && $userRole == 'employee' && $review->approved_by != $request->user()->id) {
            return $this->forbiddenResponse('', 'دسترسی غیر مجاز', 403);
        }

        $review->status = $status;
        $review->approved_by = $request->user()->id;
        $review->save();

        $company = Company::find($companyID);

        $countReview = Review::where('company_id', $companyID)
            ->where('review_type', 'REVIEW')
            ->where('status', 'PUBLISH')
            ->count();


        $countInterview = Review::where('company_id', $companyID)
            ->where('review_type', 'INTERVIEW')
            ->where('status', 'PUBLISH')
            ->count();


        $avgRate = Review::where('company_id', $companyID)
            ->where('status', 'PUBLISH')
            ->avg('rate');


        $minSalary = Review::where('company_id', $companyID)
            ->where('salary', '>=', 1000000)
            ->where('status', 'PUBLISH')
            ->min('salary');


        $maxSalary = Review::where('company_id', $companyID)
            ->where('salary', '>=', 1000000)
            ->where('status', 'PUBLISH')
            ->max('salary');


        $company->total_review = $countReview; // تعداد کل کل تجربه های تایید شده
        $company->total_interview = $countInterview; // تعداد کل کل مصاحیه های تایید شده
        $company->rate = $avgRate; // میانگین کل امتیازات شرکت تایید شده
        $company->salary_min = $minSalary ?? 0; // حداقل حقوق
        $company->salary_max = $maxSalary ?? 0; // حداکثر حقوق

        $company->save();

        ResponseCache::clear();


        return $this->successResponse($review, 201);
    }

    public function removeSexualHarassment($id)
    {
        $review = Review::whereId($id)->with('company')->first();
        $review->sexual_harassment = 0;
        $review->save();

        return $this->successResponse($review, 201);
    }
}
