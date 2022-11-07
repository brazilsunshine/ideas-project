<?php

namespace App\Http\Controllers\Ideas;

use App\Http\Controllers\Controller;
use App\Models\Idea;

class GetFilteredIdeasController extends Controller
{
    public function __invoke ()
    {
        \Log::info(request()->all());

        if (request('selectedCategory') == 0 && request('selectedFilter') == 'No Filter')
        {

            // Get all ideas
            $ideas = Idea::with(['user', 'category', 'status', 'comments.user']) // for all my ideas i wanna load this data with all my ideas
                    ->orderBy('id', 'desc') // will order the ideas by the last post date
                    ->paginate(10);
        }
        else
        {
            // filter by category_id
            if (request('selectedFilter' == 'Top Voted'))
            {
                $ideas = Idea::with(['user', 'category', 'status', 'comments.user'])
                    ->where('category_id', request('selectedCategory'))
                    ->orderBy('votesCount', 'desc') // will order the ideas by the last post date
                    ->paginate(10);
            }
            elseif (request('selectedFilter' == 'My Ideas'))
            {
                \Log::info('user');
                $ideas = Idea::with(['user', 'category', 'status', 'comments.user'])
                    ->where('user_id', auth()->user()->id)
                    ->where('category_id', request('selectedCategory'))
                    ->orderBy('id', 'desc') // will order the ideas by the last post date
                    ->paginate(10);
            }
            else
            {
                $ideas = Idea::with(['user', 'category', 'status', 'comments.user'])
                    ->where('category_id', request('selectedCategory'))
                    ->orderBy('id', 'desc') // will order the ideas by the last post date
                    ->paginate(10);
            }

        }

        return [
            'success' => true,
            'filteredIdeas' => $ideas
        ];
    }
}
