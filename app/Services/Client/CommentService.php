<?php

namespace App\Services\Client;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Comment;
use App\Models\Device;
use App\Models\Review;
use App\Traits\ApiResponse;
use Illuminate\Support\Str;

class CommentService
{
    use ApiResponse;

    private SpamService $spamService;

    public function __construct(SpamService $spamService)
    {
        $this->spamService = $spamService;
    }

    public function getComments(string | int $reviewID)
    {
        $comments = Comment::where('review_id', $reviewID)->where('status', 'PUBLISH')->paginate(50);

        return $this->okResponse($comments);
    }

    public function storeComments(StoreCommentRequest $request)
    {
        $contentType = 'COMMENT';
        $editKey = Str::random(60);
        $reviewID = $request->input('review_id');

        $payload = [
            'review_id' => $reviewID,
            'description' => $request->input('description'),
            'edit_key' => $editKey,
        ];

        $comment = Comment::create($payload);

        $isSpam = $this->spamService->isCheck($request, $contentType, $reviewID);
        if($isSpam) {
            $comment->status = 'SPAM';
            $comment->save();

            return $this->badRequestResponse("", 'اجازه ثبت دیدگاه جدید برای این تجربه را ندارید.', true);
        }


        return $this->successResponse($comment, 201);
    }

    public function updateReview(UpdateCommentRequest $request, $id)
    {
        $payload = [
            'description' => $request->input('description'),
        ];

        $comment = Comment::whereId($id)->update($payload);

        if (!$comment) {
            $this->badRequestResponse('', 'این نظر وجود ندارد.', true);
        }

        return $this->successResponse($comment, 201);
    }
}
