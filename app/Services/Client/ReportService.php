<?php

namespace App\Services\Client;

use App\Http\Requests\StoreReportRequest;
use App\Models\Review;
use App\Traits\ApiResponse;

class ReportService
{
    use ApiResponse;


    public function storeReport(StoreReportRequest $request)
    {
        $review = Review::find($request->review_id);

        if (!$review) {
            return $this->errorResponse('این تجربه وجود ندارد.', 404);
        }

        $payload = $request->only([
            'reason_id',
            'review_id',
            'description',
            'content_type',
            'comment_id'
        ]);

        $review->reports()->create($payload);

        return $this->successResponse('', 'گزارش با موفقیت ثبت شد.', 201);
    }
}
