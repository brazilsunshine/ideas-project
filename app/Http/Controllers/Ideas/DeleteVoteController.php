<?php

namespace App\Http\Controllers\Ideas;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class DeleteVoteController extends Controller
{
    use HttpResponses;

    public function __invoke (Request $request)
    {
        $userId = auth()->user()->id;

        $voteExists = Vote::where('idea_id', $request->id) // id is coming from the request in ideas actions.js
            ->where('user_id', $userId)
            ->first();

        if (!$voteExists) // if vote doesn't exist return false
        {
            return [
                'success' => false,
                'msg' => 'vote not found'
            ];
        }

        try // if vote exists
        {
            Vote::where('idea_id', $request->id) // give me the 'idea_id' that matches the idea_id coming from the request
                ->where('user_id', $userId) // where the 'user_id' matched the $userID
                ->delete(); // delete the vote
        }

        catch (\Exception $e) // if there's any problem show me in laravel.logs
        {
            \Log::info(['DeleteVoteController', $e->getMessage()]);

            return [
                'success' => false,
                'msg' => 'problem deleting'
            ];
        }

        return [
            'success' => true
        ];
    }
}
