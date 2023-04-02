<?php

namespace App\Models\Image;

use App\Models\Image\Traits\HasImageRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    use HasImageRelations;


    protected $fillable =
        [
            'id',
            'imageable_type',
            'imageable_id',
            'url'
        ];

}
