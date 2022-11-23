<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function isAdmin ()
    {
        return $this->email == "sthe@sthe.comm";
    }

    /**   RELATIONSHIPS   */
    // one user has many ideas
    public function ideas ()
    {
        return $this->hasMany(Idea::class);
    }

    // will give us the idea that the user voted for
    public function votes ()
    {
        return $this->belongsToMany(Idea::class, 'votes');
    }

    // a user has manny comments
    public function comments ()
    {
        return $this->hasMany(Comment::class);
    }

    // pivot table Comment and User
    public function likes ()
    {
        return $this->belongsToMany(Comment::class, 'likes');
    }

    // a user has one profile image
    public function profile_image ()
    {
        return $this->hasOne(UserProfileImage::class);
    }
}
