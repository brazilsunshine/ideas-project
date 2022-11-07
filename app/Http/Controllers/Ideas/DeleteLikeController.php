<?php

namespace App\Http\Controllers\Ideas;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class DeleteLikeController extends Controller
{
    use HttpResponses;

    public function __invoke (Request $request)
    {
        $userId = auth()->user()->id;

        $likeExists = Like::where('comment_id', $request->id)
            ->where('user_id', $userId)
            ->first();

        if (!$likeExists) // if like doesn't exit
        {
            return [
                'success' => false,
                'msg' => 'like not found'
            ];
        }

        try // if like exists
        {
            Like::where('comment_id', $request->id) // the id is coming from the request
                ->where('user_id', $userId)
                ->delete();
        }
        catch (\Exception $exception)
        {
            \Log::info(['DeleteLikeController', $exception->getMessage()]);

            return [
                'success' => false,
                'msg' => 'problem deleting'
            ];
        }

        return [
            'success' => true,
        ];
    }
}
