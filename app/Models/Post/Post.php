<?php

namespace App\Models\Post;

use App\Models\Post\Traits\HasPostRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    use HasPostRelations;

    protected $fillable = [
        'id',
        'content',
        'user_id'
    ];
}
