<?php

namespace App\Http\Controllers\Ideas;

use App\Http\Controllers\Controller;
use App\Models\Idea;

class GetIdeasByTitleController extends Controller
{
    public function __invoke ()
    {
        // comments.user will give us the comments with the user who created
        // give me the idea with the relations with 'user' and 'category'
        // We are eager loading the data
        $ideas = Idea::with([
            'user',
            'category',
            'status',
            'comments.user'
        ])
            // allow user to search an idea without having to type the full title
        ->where('title', 'LIKE', request('ideaTitle') . '%')
        ->paginate(10);

        return [
            'success' => true,
            'ideas' => $ideas
        ];

    }
}
