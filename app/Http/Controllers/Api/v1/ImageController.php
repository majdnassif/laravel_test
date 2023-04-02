<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUpdateRequest;
use App\Service\ImageService;
use App\Traits\Helpers\ApiResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private ImageService $imageService)
    {
    }


    public function all():JsonResponse
    {
        try {
            return $this->respondValue($this->imageService->allImages(),trans('general.index',['object' => 'Images']));
        } catch (Exception $exception) {
            return $this->respondError(trans('general.exception', ['object' => 'Image']), $exception);
        }
    }


    public function edit(ImageUpdateRequest $request):JsonResponse
    {
        try {

            if($this->imageService->updateImage($request->get('id'),$request->file('image')))
                return $this->respondSuccess(trans('general.update',['object' => 'Image']));

            return $this->respondError(trans('general.exception', ['object' => 'Image']));

        } catch (Exception $exception) {
            return $this->respondError(trans('general.exception', ['object' => 'Image']), $exception);
        }
    }


}
