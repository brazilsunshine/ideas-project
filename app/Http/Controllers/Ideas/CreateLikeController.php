<?php

namespace App\Http\Controllers\Ideas;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class CreateLikeController extends Controller
{
    use HttpResponses;

    public function __invoke (Request $request)
    {
        $userId = auth()->user()->id;

        try
        {
            Like::create([
                'comment_id' => $request->id, // create an entry in my DATABASE with the 'comment_id' that matches the comment_id coming from the request
                'user_id' => $userId,
            ]);
        }
        catch (\Exception $exception)
        {
            \Log::info(['CreateLikeController', $exception->getMessage()]);

            return [
                'success' => false,
                'msg' => 'problem creating'
            ];
        }

        return [
            'success' => true
        ];
    }
}
