<?php

namespace App\Exceptions\CustomExceptions;

use Exception;

class CreatePostException extends Exception
{
 protected $message = 'Error while creating the post';
}
