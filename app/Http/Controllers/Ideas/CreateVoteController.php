<?php

namespace App\Http\Controllers\Ideas;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class CreateVoteController extends Controller
{
    use HttpResponses;

    public function __invoke (Request $request)
    {
        $userId = auth()->user()->id;

        try
        {
            Vote::create([
                'idea_id' => $request->id, // create an entry in my DATABASE with the 'idea_id' that matches the idea_id coming from the request
                'user_id' => $userId,
            ]);
        }
        catch (\Exception $exception) // if there's any problem show me in laravel.logs
        {
            \Log::info(['CreateVoteController', $exception->getMessage()]);

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
