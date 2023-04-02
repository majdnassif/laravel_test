<?php

namespace App\Repository\Post;

use Illuminate\Database\Eloquent\Model;

interface PostInterface
{
    public function findById(int $id): ?Model;



}
