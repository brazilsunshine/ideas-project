<?php

namespace App\Http\Controllers\Ideas;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use Illuminate\Http\Request;

class UpdateIdeaStatusController extends Controller
{
    public function __invoke (Request $request)
    {
        $idea = Idea::with([
            'user',
            'category',
            'comments.user'
        ])
        ->where([
            'id' => $request->idea_id
        ])
        ->first();

        if (!$idea)
        {
            return [
                'success' => false,
                'msg' => 'idea not found'
            ];
        }

        $idea->status_id = $request->statusInt; // here I am updating the idea to become the idea with the new status from the request
        $idea->save();

        $idea->load('status'); // load the new status

        return [
            'success' => true,
            'idea' => $idea
        ];
    }
}
