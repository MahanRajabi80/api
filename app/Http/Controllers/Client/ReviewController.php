<?php

namespace App\Http\Controllers\Client;

use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Services\Client\ReviewService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ApiResponse;

    private ReviewService $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
        $this->middleware('doNotCacheResponse', ['only' => ['store', 'update']]);
        $this->middleware('throttle:2,1440', ['only' => ['store']]);
        $this->middleware('throttle:5,1440', ['only' => ['update']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->reviewService->getReviews($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        return $this->reviewService->storeReview($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return $this->reviewService->getReview($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, $id)
    {
        return $this->reviewService->updateReview($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
}
