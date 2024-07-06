<?php

namespace App\Services\Admin;

use App\Http\Requests\ChangeCommentStatusRequest;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Review;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Spatie\ResponseCache\Facades\ResponseCache;

class CommentService
{
    use ApiResponse;

    public function getComments(Request $request)
    {
        $q = $request->input('q');
        $status = $request->input('status');

        $query = Comment::with(['review' => function ($query) {
            $query->select('id', 'title');
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


    public function changeStatus(ChangeCommentStatusRequest $request, $id)
    {
        $userRole = $request->user()->role;
        $status = $request->input('status');


        $comment = Comment::whereId($id)->first();

        if ($comment->approved_by != null && $userRole == 'employee' && $comment->approved_by != $request->user()->id) {
            return $this->forbiddenResponse('', 'دسترسی غیر مجاز', 403);
        }

        $comment->status = $status;
        $comment->approved_by = $request->user()->id;
        $comment->save();

        return $this->successResponse($comment, 201);
    }
}
