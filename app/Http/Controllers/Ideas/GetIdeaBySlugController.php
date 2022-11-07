<?php

namespace App\Http\Controllers\Ideas;

use App\Http\Controllers\Controller;
use App\Models\Idea;

class GetIdeaBySlugController extends Controller
{
    public function __invoke ($slug)
    {
        // comments.user will give us the comments with the user who created
        $idea = Idea::with(['user', 'category', 'status', 'comments.user']) // give me the idea with the relations with 'user' and 'category'
            ->where('slug', $slug) // get the idea that matches the slug
            ->first();

        return [
            'idea' => $idea
        ];
    }
}
