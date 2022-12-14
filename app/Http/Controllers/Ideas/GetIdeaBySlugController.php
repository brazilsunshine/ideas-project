<?php

namespace App\Http\Controllers\Ideas;

use App\Http\Controllers\Controller;
use App\Models\Idea;

class GetIdeaBySlugController extends Controller
{
    public function __invoke ($slug)
    {
        // comments.user will give us the comments with the user who created
        // give me the idea with the relations with 'user' and 'category'
        // We are eager loading the data
        $idea = Idea::with([
            'user',
            'category',
            'status',
            'comments.user'
        ])
        ->where('slug', $slug) // get the idea that matches the slug
        ->first();

        return [
            'idea' => $idea
        ];
    }
}
