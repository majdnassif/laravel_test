<?php

namespace App\Repository\Post;

use App\Models\Post\Post;
use App\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class PostRepository extends BaseRepository implements PostInterface
{
    public function __construct(readonly private Post $model)
    {
        parent::__construct($model);
    }

    public function findById(int $id): ?Model
    {
        return $this->model->find($id);
    }
}
