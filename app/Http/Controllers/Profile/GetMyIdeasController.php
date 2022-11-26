<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use Illuminate\Http\Request;

class GetMyIdeasController extends Controller
{
    /**
     * Get the authenticated user's ideas
     */
    public function __invoke ()
    {
        $ideas = Idea::with([
            'user.profile_image',
            'category',
            'status',
            'comments.user'
        ])->where('user_id', auth()->user()->id)
          ->orderBy('id', 'desc')
          ->paginate(10);

        return [
            'success' => true,
            'ideas' => $ideas
        ];


    }

}
