<?php

namespace App\Http\Controllers\Ideas;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use Illuminate\Http\Request;

class GetPaginatedIdeasController extends Controller
{
    /**
     * Get all ideas from DB with the respective user who created
     * with the category the idea belongs and paginate the ideas
     */
    public function __invoke ()
    {
        // comments.user will give us the comments with the user who created
        $ideas = Idea::with(['user', 'category', 'status', 'comments.user'])
            ->orderBy('id', 'desc') // will order the ideas by the last post date
            ->paginate(10);

        return [
            'success' => true,
            'ideas' => $ideas
        ];
    }
}
