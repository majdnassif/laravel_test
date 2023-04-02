<?php

namespace App\Repository\User;

use App\Models\User\User;
use App\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserInterface
{
    public function __construct(readonly private User $model)
    {
        parent::__construct($model);
    }

    public function findById(int $id): ?Model
    {
        return $this->model->find($id);
    }
}
