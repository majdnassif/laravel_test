<?php

namespace App\Models\User\Traits;

use App\Models\Image\Image;
use App\Models\Post\Post;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasUserRelations
{

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class,'imageable');
    }

    public function posts():HasMany
    {
        return $this->hasMany(Post::class);
    }

}
