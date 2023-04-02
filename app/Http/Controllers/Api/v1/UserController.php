<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Service\UserService;
use App\Traits\Helpers\ApiResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private UserService $userService)
    {
    }

    public function all():JsonResponse
    {
        try {

            return $this->respondValue($this->userService->allUsers(),trans('general.index',['object' => 'Users']));

        } catch (Exception $exception) {
            return $this->respondError(trans('general.exception', ['object' => 'User']), $exception);
        }
    }


    public function store(UserCreateRequest $request):JsonResponse
    {
        try {
            $userResource = new UserResource($this->userService->create(name:$request->get('name'), email: $request->get('email'),password: $request->get('password'),image:$request->file('image')));
            return $this->respondWithResource($userResource,trans('general.store',['object' => 'User']));
        } catch (Exception $exception) {
            return $this->respondError(trans('general.exception', ['object' => 'User']), $exception);
        }
    }

    public function show(string $userId):JsonResponse
    {
        try {
            if(!$this->userService->isUserExist($userId))
                return $this->respondNotFound('User Not Found!!');
            $userResource = new UserResource($this->userService->show($userId));
            return $this->respondWithResource($userResource,trans('general.show',['object' => 'User']));
        } catch (Exception $exception) {
            return $this->respondError(trans('general.exception', ['object' => 'User']), $exception);
        }
    }

    public function edit(UserUpdateRequest $request):JsonResponse
    {

        try {
            if(!$this->userService->isUserExist($request->get('id')))
                return $this->respondNotFound('User Not Found!!');


            if($this->userService->updateUser($request->get('id'),$request->all(),$request->file('image')))
                return $this->respondSuccess(trans('general.update',['object' => 'User']));

            return $this->respondError(trans('general.exception', ['object' => 'User']));

        } catch (Exception $exception) {
            return $this->respondError(trans('general.exception', ['object' => 'User']), $exception);
        }
    }

}
