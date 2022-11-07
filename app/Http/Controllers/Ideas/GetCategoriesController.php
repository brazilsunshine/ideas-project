<?php

namespace App\Http\Controllers\Ideas;

use App\Http\Controllers\Controller;
use App\Models\Category;

class GetCategoriesController extends Controller
{
    /**
     * Get all categories from database
     */
    public function __invoke ()
    {
        $categories = Category::all();

        return [
            'success' => true,
            'categories' => $categories
        ];
    }
}
