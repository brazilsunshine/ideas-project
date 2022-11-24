<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = [];

    public $appends = [
        'diffForHumans',
        'votesCount',
        'isVotedByUser',
        'commentsCount'
    ];

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * Here I am making the diffForHumans available in my Vue
     */
    public function getDiffForHumansAttribute ()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Here I am making the votesCount available in my Vue
     */
    public function getVotesCountAttribute ()
    {
        return $this->votes->count();
    }

    /**
     * Here I am making the votesCount available in my Vue
     */
    public function getCommentsCountAttribute ()
    {
        return $this->comments->count();
    }

    /**
     * Here I am making the isVotedByUser available in my Vue
     */
    public function getIsVotedByUserAttribute ()
    {
        if (!auth()->check()) // check if user is not authenticated, if it's not, return false
        {
            return false;
        }

        $userId = auth()->user()->id; // the method user() will get the currently authenticated user.

        // return on the votes table the 'user_id' that matches with the $user_id that clicked on the id
        return Vote::where('user_id', $userId)
            ->where('idea_id', $this->id) // we are on the Idea modal, so we don't need to write $idea_id, so $this->id works
            ->exists();
            // return on the votes table the 'idea_id' that matches with the $idea_id clicked by the user;
    }

    /**   RELATIONSHIPS   */
    // idea belongs to user
    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    // idea belongs to a category;
    public function category ()
    {
        return $this->belongsTo(Category::class);
    }

    // idea belongs to status
    public function status ()
    {
        return $this->belongsTo(Status::class);
    }

    // will give us the list of users that voted for this particular idea
    public function votes ()
    {
        return $this->belongsToMany(User::class, 'votes', 'idea_id', 'user_id');
    }

    /**
     * One Idea has many Comments
     *
     * Comments will be ordered Newest -> Oldest
     */
    public function comments ()
    {
        return $this->hasMany(Comment::class)->orderBy('id', 'desc');
    }

}

