<?php
namespace App\Core\Helpers;
use Exception;

class Csrf
{
    /**
     * @throws Exception
     */
    public function generateCsrfToken(): string
    {


        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public function validateCsrfToken(string $token): bool
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}