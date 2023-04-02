<?php

namespace App\Repository\Image;

use Illuminate\Database\Eloquent\Model;

interface ImageInterface
{
    public function findImageBaseOnTypeAndId(string $modelType,string $modelId):?Model;

    public function findById(int $id): ?Model;

}
