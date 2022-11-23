<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * BACKEND ROUTES
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** Public routes (available for all users) */
Route::post('/register', 'Auth\RegisterController');
Route::post('/login', 'Auth\LoginController');

Route::get('/user/check-auth', 'Auth\CheckAuthController');


Route::get('/ideas/get-paginated', 'Ideas\GetPaginatedIdeasController');
Route::get('/ideas/get-idea-by-slug/{slug}', 'Ideas\GetIdeaBySlugController');
Route::get('/ideas/get-categories', 'Ideas\GetCategoriesController');
Route::get('/ideas/get-paginated-ideas-by-status-id', 'Ideas\GetPaginatedIdeasByStatusIdController');
Route::get('/ideas/count-ideas-by-status', 'Ideas\CountIdeasByStatusController');
Route::get('/ideas/get-filtered-ideas', 'Ideas\GetFilteredIdeasController');
Route::get('/ideas/get-ideas-by-title', 'Ideas\GetIdeasByTitleController');



/** Protected routes (only authenticated users can access) */
// The middleware auth:sanctum is making only authenticated users have access the routes inside the curly brackets.
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', 'Auth\LogoutController');

    Route::post('/create-idea', 'Ideas\CreateIdeaController');

    Route::post('/ideas/delete-vote', 'Ideas\DeleteVoteController');
    Route::post('/ideas/create-vote', 'Ideas\CreateVoteController');
    Route::post('/ideas/create-a-new-comment', 'Ideas\CreateANewCommentController');
    Route::post('/ideas/create-like', 'Ideas\CreateLikeController');
    Route::post('/ideas/delete-like', 'Ideas\DeleteLikeController');
    Route::post('/ideas/update-idea-status', 'Ideas\UpdateIdeaStatusController');

    Route::post('/profile/upload-image', 'Profile\UploadImageController');
    Route::post('/profile/edit-profile', 'Profile\EditProfileController');
});


