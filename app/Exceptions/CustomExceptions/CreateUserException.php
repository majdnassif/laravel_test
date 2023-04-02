<?php

namespace App\Exceptions\CustomExceptions;

use Exception;

class CreateUserException extends Exception
{
 protected $message = 'Error in create user';
}
