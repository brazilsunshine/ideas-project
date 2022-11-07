<?php

namespace App\Http\Controllers\Ideas;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class CreateANewCommentController extends Controller
{
    use HttpResponses;

    public function __invoke (Request $request)
    {
        $userId = auth()->user()->id;

        try {
            $comment = Comment::create([
                'comment' => $request->comment,
                'idea_id' => $request->idea_id,
                'user_id' => $userId,
                'is_admin' => false,
                'is_viewed' => false,
            ]);
        }
        catch (\Exception $exception)
        {
            \Log::info(['CreateANewCommentController', $exception->getMessage()]);

            return [
                'success' => false,
                'msg' => 'problem creating'
            ];
        }

        return [
            'success' => true,
            'comment' => $comment->load('user') // load comment with user
        ];
    }
}
