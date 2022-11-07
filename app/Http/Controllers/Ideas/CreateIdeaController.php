<?php

namespace App\Http\Controllers\Ideas;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateIdeaController extends Controller
{
    use HttpResponses;

    public function __invoke (Request $request) // I'm receiving the request coming from post request in CreatedIdea.vue
    {
        $request->validate([
            'title' => 'required|min:4',
            'description' => 'required|min:4',
            'category_id' => 'required|integer',
        ]);

        try
        {
            $idea = Idea::create([
                'user_id' => auth()->id(),
                'category_id' => $request->category_id,
                'status_id' => 1,
                'title' => $request->title, // the title is coming from the request in CreateIdea.vue
                'description' => $request->description, // the description is coming from the request in CreateIdea.vue
            ]);
        }

        catch (\Exception $exception)
        {
            \Log::info(['CreateIdeaController', $exception->getMessage()]);

            return [
                'success' => false,
                'msg' => 'problem'
            ];
        }


        return [
            'success' => true,
            'idea' => $idea
        ];
    }
}
