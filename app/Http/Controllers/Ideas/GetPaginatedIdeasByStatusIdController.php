<?php

namespace App\Http\Controllers\Ideas;

use App\Http\Controllers\Controller;
use App\Models\Idea;

class GetPaginatedIdeasByStatusIdController extends Controller
{
    public function __invoke ()
    {
        $ideas = Idea::with(['user', 'category', 'status', 'comments.user'])
            // when it's a get request and we want to receive data from the request, we use the request() helper
            ->where('status_id', request('statusId'))
            ->orderBy('id', 'desc') // will order the ideas by the last post date
            ->paginate(10);

        return [
            'success' => true,
            'ideas' => $ideas
        ];
    }
}
