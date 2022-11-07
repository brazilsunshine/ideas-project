<?php

namespace App\Http\Controllers\Ideas;

use App\Http\Controllers\Controller;
use App\Models\Idea;

class CountIdeasByStatusController extends Controller
{
    public function __invoke ()
    {
        $ideasCount = Idea::count();

        $consideringCount = Idea::where('status_id', 2)->count();

        $inProgressCount = Idea::where('status_id', 3)->count();

        $implementedCount = Idea::where('status_id', 4)->count();

        $closedCount = Idea::where('status_id', 5)->count();

        return [
            'success' => true,
            'all' => $ideasCount,
            'considering' => $consideringCount,
            'inProgress' => $inProgressCount,
            'implemented' => $implementedCount,
            'closed' => $closedCount
        ];

    }
}
