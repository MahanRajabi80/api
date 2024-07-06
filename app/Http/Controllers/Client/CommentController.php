<?php

namespace App\Http\Controllers\Client;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Services\Client\CommentService;
use App\Traits\ApiResponse;

class CommentController extends Controller
{
    use ApiResponse;

    private CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
        $this->middleware('throttle:10,5', ['only' => ['store', 'update']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string | int $reviewID)
    {
        return $this->commentService->getComments($reviewID);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        return $this->commentService->storeComments($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }
}
