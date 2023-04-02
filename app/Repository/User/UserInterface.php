<?php

namespace App\Repository\User;

use Illuminate\Database\Eloquent\Model;

interface UserInterface
{
    public function findById(int $id): ?Model;

}
