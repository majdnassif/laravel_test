<?php

namespace App\Models\PostEvent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'amount'
    ];
}
