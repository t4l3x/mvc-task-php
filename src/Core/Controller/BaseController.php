<?php

namespace App\Core\Controller;

use Exception;
use Nyholm\Psr7\Response;
use Twig\Environment;

class BaseController
{

    protected Environment $twig;
    public bool $enableCsrfValidation = true;

    /**
     * @throws Exception
     */
    protected function render(string $template, array $data = []): Response
    {
        $content = $this->twig->render($template, $data);
        return $response = new Response(
            200,
            ['Content-Type' => 'text/html'],
            $content
        );
    }

//    protected function validateCsrfToken(Request $request): bool
//    {
//        if ($this->enableCsrfValidation) {
//            $csrfToken = $request->getParsedBody()['csrf_token'] ?? '';
//            if (!$this->csrfService->validateCsrfToken($csrfToken)) {
//                throw new \Exception("Invalid CSRF token.");
//            }
//        }
//
//        return true;
//    }

    protected function redirect(string $url): Response
    {
        return new Response(302, ['Location' => $url]);
    }
}