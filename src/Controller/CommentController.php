<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/comments')]
class CommentController extends AbstractController
{
    #[Route('/{articleId}', name: 'create_comment', methods: ['POST'])]
    public function createComment(int $articleId, Request $request, ArticleRepository $articleRepo, EntityManagerInterface $em): JsonResponse
    {
        $article = $articleRepo->find($articleId);

        if (!$article) {
            return new JsonResponse(['message' => 'Article not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        if (!isset($data['content'])) {
            return new JsonResponse(['message' => 'Invalid data'], 400);
        }

        $comment = new Comment();
        $comment->setContent($data['content']);
        $comment->setArticle($article);

        $em->persist($comment);
        $em->flush();

        return new JsonResponse(['message' => 'Comment added'], 201);
    }

    #[Route('/{articleId}', name: 'get_comments', methods: ['GET'])]
    public function getComments(int $articleId, ArticleRepository $articleRepo): JsonResponse
    {
        $article = $articleRepo->find($articleId);

        if (!$article) {
            return new JsonResponse(['message' => 'Article not found'], 404);
        }

        $comments = $article->getComments()->map(fn($comment) => [
            'id' => $comment->getId(),
            'content' => $comment->getContent(),
        ])->toArray();

        return new JsonResponse(['comments' => $comments]);
    }

    #[Route('/delete/{id}', name: 'delete_comment', methods: ['DELETE'])]
    public function deleteComment(int $id, CommentRepository $commentRepo, EntityManagerInterface $em): JsonResponse
    {
        $comment = $commentRepo->find($id);

        if (!$comment) {
            return new JsonResponse(['message' => 'Comment not found'], 404);
        }

        $em->remove($comment);
        $em->flush();

        return new JsonResponse(['message' => 'Comment deleted'], 200);
    }
}
