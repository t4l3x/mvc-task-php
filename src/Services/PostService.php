<?php

namespace App\Services;


use App\Services\NotificationService;
use App\Model\PostModel;
use Exception;

class PostService
{
    private PostModel $post;
    private NotificationService $notificationService;


    public function __construct(PostModel $post, NotificationService $notificationService)
    {
        $this->post = $post;
        $this->notificationService = $notificationService;
    }

    /**
     * @throws Exception
     */
    public function createPost($data): bool
    {
        try {
           $post = $this->post->storeData($data);
            // Notify that a new post has been created
            $this->notificationService->sendEmail('t4@gmail.com', 't2@gmail.com', 'New post created', 'A new post has been created');
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getPosts(): array
    {
        return $this->post->getAllData();
    }

}