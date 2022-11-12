<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'diffForHumans',
        'likesCount',
        'display',
        'isCommentLikedByCurrentUser',
    ];

    /**
     * Here I am making diffForHumans available for my comments
     */
    public function getDiffForHumansAttribute ()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * likesCount available for comments
     */
    public function getLikesCountAttribute ()
    {
        return $this->likes->count();
    }

    /**
     * Append to display the spam dialog in the comments in selectedIdea.vue is false by default
     */
    public function getDisplayAttribute ()
    {
        return false;
    }

    public function getIsCommentLikedByCurrentUserAttribute ()
    {
        if (!auth()->check())
        {
            return false;
        }

        $userId = auth()->user()->id;

        return Like::where('user_id', $userId)
            ->where('comment_id', $this->id)
            ->exists();

    }

    /**   RELATIONSHIPS   */
    // comment belongs to a user
    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    // comment belongs to an idea
    public function idea ()
    {
        return $this->belongsTo(Idea::class);
    }

    // will give us the list of users that liked this particular comment
    // pivot table Comment and User
    public function likes ()
    {
        return $this->belongsToMany(User::class,'likes', 'comment_id', 'user_id');
    }

}
