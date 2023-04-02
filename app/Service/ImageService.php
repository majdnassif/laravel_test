<?php

namespace App\Service;

use App\Models\Image\Image;
use App\Repository\Image\ImageRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\QueryBuilder\QueryBuilder;

class ImageService
{

    public function __construct(private ImageRepository $imageRepository)
    {
    }

    public  function create(string $model_type,string $model_id,string $url):?Model
    {
     return $this->imageRepository->create(['imageable_type'=>$model_type, 'imageable_id'=>$model_id,'url'=>$url]);
    }


    public function allImages():?Collection
    {
        return QueryBuilder::for(Image::class)
            ->allowedFilters(['id','imageable_type','imageable_id'])
            ->defaultSort('imageable_type')
            ->get();
    }


    public function updateImage(int $imageId, ?UploadedFile $image):bool
    {
        if(!$this->isImageExist($imageId))
            return false;

            $imageModel = $this->imageRepository->findById($imageId);

            $url = $image->store('image');

          return  $this->imageRepository->update($imageModel,['url'=>$url]);
    }


    public function isImageExist(int $imageId):bool
    {
        return $this->imageRepository->findById($imageId) ? true : false;
    }

    public  function update(string $model_type,string $model_id,string $newUrl):?Model
    {
        $image = $this->imageRepository->findImageBaseOnTypeAndId($model_type,$model_id);
        if($image)
            $this->imageRepository->update($image,['url'=>$newUrl]);

        return $image;
    }



}
