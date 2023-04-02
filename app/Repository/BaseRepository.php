<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements EloquentRepositoryInterface {

    public function __construct(private Model $model) { }

    public function all(array $relationships) :LengthAwarePaginator {
        return $this->model
            ->with($relationships)
            ->paginate(15);
    }

    public function create(array $model) : ?Model {
        return $this->model
            ->query()
            ->create($model);
    }

    public function update(Model $model , array $payload) : bool {
        return $model->update($payload);
    }

    public function find(int $id , array $relationships) : ?Model {
        return $this->model
            ->with($relationships)
            ->find($id);
    }

    public function delete(int $id) : bool {
        return $this->model
            ->query()
            ->find($id)
            ->delete();
    }

    public function allWithOutPaginate($relationships)
    {
        return $this->model
            ->with($relationships)
            ->get();

    }


}

