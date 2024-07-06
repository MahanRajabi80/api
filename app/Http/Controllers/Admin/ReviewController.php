<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ChangeReviewStatusRequest;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Services\Admin\ReviewService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ApiResponse;

    private ReviewService $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function index(Request $request)
    {
        return $this->reviewService->getReviews($request);
    }

    public function changeStatus(ChangeReviewStatusRequest $request, $id)
    {
        return $this->reviewService->changeStatus($request, $id);
    }

    public function removeSexualHarassment($id)
    {
        return $this->reviewService->removeSexualHarassment($id);
    }
}
