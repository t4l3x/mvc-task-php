<?php

namespace App\Controller;

use App\Core\Controller\BaseController;
use App\Core\Helpers\Csrf;
use App\Services\PostService;
use Exception;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment;

class PostsController extends BaseController
{
    private PostService $postService;
    protected Environment $twig;

    private Csrf $csrf_token;

    public function __construct(PostService $postService, Environment $twig, Csrf $csrf)
    {
        $this->csrf_token = $csrf;
        $this->postService = $postService;
        $this->twig = $twig;
    }

    /**
     * @throws Exception
     */
    public function home()
    {
        $csrf_token = $this->csrf_token->generateCsrfToken();
        $post = $this->postService->getPosts();

        return $this->render('form.twig', ['csfr_token' => $csrf_token,'posts' => $post]); // add $data if needed
    }

    /**
     * @throws Exception
     */
    public function create(Request $request): Response|\Psr\Http\Message\MessageInterface
    {
        $postData = $request->getParsedBody();
        if($this->csrf_token->validateCsrfToken($postData['csrf_token']) &&  $this->postService->createPost($postData)){;
            return $this->redirect('/articles'); // assuming '/home' is the correct path
        }else{
            return $this->render('error.html.twig', ['error' => 'CSRF token is not valid']);
        }

    }
}