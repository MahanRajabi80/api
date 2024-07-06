<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ChangeCommentStatusRequest;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Services\Admin\CommentService;
use App\Services\Admin\ReviewService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use ApiResponse;

    private CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index(Request $request)
    {
        return $this->commentService->getComments($request);
    }


    public function changeStatus(ChangeCommentStatusRequest $request, $id)
    {
        return $this->commentService->changeStatus($request, $id);
    }
}
