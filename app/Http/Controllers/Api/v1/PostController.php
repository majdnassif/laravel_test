<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Http\Resources\PostResource;
use App\Service\PostService;
use App\Traits\Helpers\ApiResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{

    use ApiResponseTrait;
    public function __construct(private PostService $postService)
    {
    }


    public function all():JsonResponse
    {
        try {

            return $this->respondValue($this->postService->allPosts(),trans('general.index',['object' => 'Posts']));

        } catch (Exception $exception) {
            return $this->respondError(trans('general.exception', ['object' => 'Post']), $exception);
        }
    }



    public function store(PostCreateRequest $request):JsonResponse
    {
        try {
            $postResource = new PostResource($this->postService->create($request->get('user_id'),$request->get('content'), $request->file('images')));
            return $this->respondWithResource($postResource,trans('general.store',['object' => 'Post']));
        } catch (Exception $exception) {
            return $this->respondError(trans('general.exception', ['object' => 'Post']), $exception);
        }
    }


    public function show(string $postId):JsonResponse
    {

        try {

            if(!$this->postService->isPostExist($postId))
                return $this->respondNotFound('User Not Found!!');

            $postResource = new PostResource($this->postService->show($postId));
            return $this->respondWithResource($postResource,trans('general.show',['object' => 'Post']));

        } catch (Exception $exception) {
            return $this->respondError(trans('general.exception', ['object' => 'Post']), $exception);
        }
    }


}
