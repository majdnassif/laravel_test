<?php

namespace App\Models\Image\Traits;

use Illuminate\Database\Eloquent\Relations\MorphTo;

trait HasImageRelations
{
    public function imageabel() : MorphTo
    {
        return $this->morphTo();
    }
}
