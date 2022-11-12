<?php

namespace App\Http\Controllers\Ideas;

use App\Http\Controllers\Controller;
use App\Models\Idea;

class GetFilteredIdeasController extends Controller
{
    public function __invoke ()
    {
        $query = Idea::query();

        // load this data with my ideas
        $query->with(['user', 'category', 'status', 'comments.user']);

        // ALL IDEAS  + NO FILTER
        if (request('selectedCategory') == 0 && request('selectedFilter') == 'No Filter')
        {
            $query->orderBy('id', 'desc');
        }
        else
        {
            // TOP VOTED FILTER
            if (request('selectedFilter') == 'Top Voted')
            {
                $query->withCount('votes')
                      ->orderBy('votes_count', 'desc');

                // CATEGORY WHEN CATEGORY_ID MATCHES THE CATEGORY COMO REQUEST
                if (request('selectedCategory') != 0) // 0 is ALL IDEAS
                {
                    $query->where('category_id', request('selectedCategory'));
                }
            }
            // MY IDEAS FILTER
            elseif (request('selectedFilter') == 'My Ideas')
            {
                $query
                    ->where('user_id', auth()->user()->id)
                    ->orderBy('id', 'desc');

                // CATEGORY WHEN CATEGORY_ID MATCHES THE CATEGORY COMO REQUEST
                if (request('selectedCategory') != 0) // 0 is ALL IDEAS
                {
                    $query->where('category_id', request('selectedCategory'));
                }
            }
            // ELSE JUST FILTER BY CATEGORY
            else
            {
                $query
                    ->where('category_id', request('selectedCategory'))
                    ->orderBy('id', 'desc');
            }
        }

        $ideas = $query->paginate(10);

        return [
            'success' => true,
            'filteredIdeas' => $ideas
        ];
    }
}
