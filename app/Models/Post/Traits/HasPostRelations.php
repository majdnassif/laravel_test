<?php

namespace App\Models\Post\Traits;

use App\Models\Image\Image;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasPostRelations
{
  public function images():MorphMany
  {
      return $this->morphMany(Image::class,'imageable');
  }

  public function user():BelongsTo
  {
      return $this->belongsTo(User::class,'user_id');
  }
}
