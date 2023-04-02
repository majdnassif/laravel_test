<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface EloquentRepositoryInterface
{

    public function all(array $relationships) :LengthAwarePaginator;

    public function create(array $model) : ?Model;

    public function update(Model $model , array $payload) : bool;

    public function find(int $id , array $relationships) : ?Model;

    public function delete(int $id) : bool;
}
