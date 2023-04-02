<?php

namespace App\Repository\Image;

use App\Models\Image\Image;
use App\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class ImageRepository extends BaseRepository implements ImageInterface
{
    public function __construct(readonly private Image $model)
    {
        parent::__construct($model);
    }

    public function findImageBaseOnTypeAndId(string $modelType,string $modelId):?Model
    {
       return $this->model
           ->where('imageable_type',$modelType)
           ->where('imageable_id',$modelId)
           ->first();
    }


    public function findById(int $id): ?Model
    {
        return $this->model->find($id);
    }


}
