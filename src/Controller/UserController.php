<?php

namespace App\Controller;

use App\Formatter\ApiResponseFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends AbstractController
{
    #[Route('/api/users/show', name: 'user_show', methods: ['GET'])]
    public function showUser(ApiResponseFormatter $responseFormatter): JsonResponse
    {
        $currentUser = $this->getUser();

        if (!$currentUser) {
            return $responseFormatter
                ->withMessage('User not authenticated')
                ->withStatusCode(401)
                ->getResponse();
        }

        return $responseFormatter
            ->withData([
                'user_id' => $currentUser->getId(),
                'user_email' => $currentUser->getEmail(),
            ])
            ->withMessage('User retrieved successfully')
            ->withStatusCode(200)
            ->getResponse();
    }
}
