<?php

namespace App\Service;

use App\Exceptions\CustomExceptions\CreateUserException;
use App\Models\Image\Image;
use App\Models\User\User;
use App\Repository\User\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class UserService
{

private array $relationships = ['image'];
  public function __construct(private UserRepository $userRepository,private ImageService $imageService)
  {
  }

    public function create(string $name, string $email, string $password ,?UploadedFile $image = null) :mixed
    {
        try {
           $user =  $this->userRepository->create(['name'=>$name,'email'=>$email,'password' => $password]);
        }
        catch (CreateUserException $e)
        {
            return $e->getMessage();
        }

        if($image)
        {
            $url = $image->store('image');
            $this->imageService->create(User::class,$user['id'],$url);
        }

        return $user;
    }

    public function show(string $userId):?Model
    {
        return $this->userRepository->find($userId,$this->relationships);
    }

    public function allUsers(): Collection|array
    {
        return QueryBuilder::for(User::class)
            ->allowedFilters(['name','id'])
            ->allowedIncludes(['posts','image'])
            ->defaultSort('name')
            ->allowedSorts('name')
            ->get();
    }

    public function updateUser(int $userId, array $data, ?UploadedFile $image = null):?bool
    {
        if(!$this->isUserExist($userId))
            return null;

        $user = $this->userRepository->findById($userId);

        if($image)
        {
            $url = $image->store('image');
            $this->imageService->update(User::class,$user['id'],$url);
        }
        $payloadData = $this->getPayloadData($data);
        return $this->userRepository->update($user, $payloadData);

    }
    public function getPayloadData(array $data): ?array
    {
        $newUserInfo = [];

        if($data['name'])
            $newUserInfo['name']  = $data['name'];

        if($data['password'])
            $newUserInfo['password']  = $data['password'];

        if($data['email'])
            $newUserInfo['email']  = $data['email'];

        return $newUserInfo;
    }

    public function isUserExist(int $userId):bool
    {
        return $this->userRepository->findById($userId) ? true : false;
    }
}
