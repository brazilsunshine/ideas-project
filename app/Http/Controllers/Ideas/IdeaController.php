<?php

namespace App\Http\Controllers\Ideas;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\Idea;

class IdeaController extends Controller
{
    /**
     *
     */
    public function index ()
    {
        return view('root', [
            'idea' => null,
        ]);
    }

    /**
     * Load one Idea
     */
    public function show ($id) // Here we are passing in the id coming from /ideas/{id} on web.php
    {
        // Get the first Idea with the user who created the Idea,
        // where the 'id' of the Idea in the Idea's table matches the $id of the Idea picked by the user
        $idea = Idea::with('user')->where('id', $id)->first();

        // 'idea' will be the $idea with the user who created clicked by some user
        return view('root', [
            'idea' => $idea,
        ]);
    }


}
