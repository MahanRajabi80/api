<?php

namespace App\Services\Client;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Review;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReviewService
{
    use ApiResponse;

    private SpamService $spamService;

    public function __construct(SpamService $spamService)
    {
        $this->spamService = $spamService;
    }

    public function getReviews(Request $request)
    {
        $companyID = $request->input('company_id');
        $exceptID = $request->input('except');
        $perPage = min($request->input('per_page', 10), 10);

        $query = Review::with(['company:id,slug,name'])
            ->orderBy('id', 'DESC')
            ->where('status', 'PUBLISH');

        if ($companyID) {
            $query->where('company_id', $companyID);
        }

        if ($exceptID) {
            $query->whereNotIn('id', (array)$exceptID);
        }

        $reviews = $query->paginate($perPage)->through(function ($row) {
            $row->description = Str::limit(strip_tags($row->description), 160);
            return $row;
        });

        return $this->okResponse($reviews);
    }

    public function getReview(Request $request, $id)
    {
        $key = $request->input('key');

        $reviewQuery = Review::with('company:id,slug,name')->where('id', $id);

        $reviewQuery->when(
            $key,
            fn($query) => $query->where('edit_key', $key),
            fn($query) => $query->where('status', 'PUBLISH')
        );

        $review = $reviewQuery->first();

        if (!$review) {
            return $this->notFoundResponse('', 'این تجربه وجود ندارد.', true);
        }

        return $this->okResponse($review);
    }

    public function storeReview(StoreReviewRequest $request)
    {
        $payload = $request->only([
            'company_id',
            'review_type',
            'title',
            'job_title',
            'description',
            'rate',
            'salary',
            'start_date',
            'review_status',
            'sexual_harassment',
        ]);
        $payload['edit_key'] = Str::random(60);

        $review = Review::create($payload);

        if ($this->spamService->isCheck($request, $payload['review_type'], $payload['company_id'])) {
            $review->update(['status' => 'SPAM']);
            return $this->badRequestResponse('', 'اجازه ثبت تجربه جدید برای این شرکت را ندارید.', true);
        }

        return $this->successResponse($review->makeVisible('edit_key'), 201);
    }

    public function updateReview(UpdateReviewRequest $request, $id)
    {
        $review = Review::find($id);

        if (!$review) {
            return $this->badRequestResponse('', 'این تجربه وجود ندارد.', true);
        }

        $key = $request->input('key');
        if ($review->edit_key != $key) {
            return $this->badRequestResponse('', 'کلید ویرایش صحیح نمی باشد.', true);
        }

        $payload = $request->only([
            'title',
            'description',
            'job_title',
            'salary',
            'rate',
            'start_date',
            'review_status',
            'sexual_harassment',
        ]);

        $review->update($payload);

        return $this->successResponse($review, 201);
    }
}
