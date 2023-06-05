<?php

namespace App\Core\Database\Exceptions;

use Throwable;

class DatabaseConnection extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("Database Connection Error: Invalid credentials", $code, $previous);
    }
}