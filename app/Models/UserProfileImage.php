<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserProfileImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'path'
    ];

    /**
     * Get Local path for images in dev mode
     */
    public function getPathAttribute () {
        return Storage::disk('local')->path($this->url);
    }
}
