<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/articles')]
class ArticleController extends AbstractController
{
    #[Route('', name: 'create_article', methods: ['POST'])]
    public function createArticle(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['title']) || !isset($data['content'])) {
            return new JsonResponse(['message' => 'Invalid data'], 400);
        }

        $article = new Article();
        $article->setTitle($data['title']);
        $article->setContent($data['content']);

        $em->persist($article);
        $em->flush();

        return new JsonResponse(['message' => 'Article created'], 201);
    }

    #[Route('/{id}', name: 'update_article', methods: ['PUT'])]
    public function updateArticle(int $id, Request $request, ArticleRepository $repo, EntityManagerInterface $em): JsonResponse
    {
        $article = $repo->find($id);

        if (!$article) {
            return new JsonResponse(['message' => 'Article not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        if (isset($data['title'])) {
            $article->setTitle($data['title']);
        }
        if (isset($data['content'])) {
            $article->setContent($data['content']);
        }

        $em->flush();

        return new JsonResponse(['message' => 'Article updated'], 200);
    }

    #[Route('/{id}', name: 'delete_article', methods: ['DELETE'])]
    public function deleteArticle(int $id, ArticleRepository $repo, EntityManagerInterface $em): JsonResponse
    {
        $article = $repo->find($id);

        if (!$article) {
            return new JsonResponse(['message' => 'Article not found'], 404);
        }

        $em->remove($article);
        $em->flush();

        return new JsonResponse(['message' => 'Article deleted'], 200);
    }

    #[Route('/search', name: 'search_articles', methods: ['GET'])]
    public function searchArticles(ArticleRepository $repo, Request $request): JsonResponse
    {
        $query = $request->query->get('q', '');

        if (empty($query)) {
            return $this->json(['message' => 'Provide a search query'], 400);
        }

        $articles = $repo->createQueryBuilder('a')
            ->where('a.title LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();

        return $this->json(array_map(fn($article) => [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => substr($article->getContent(), 100) . '...',
        ], $articles));
    }

    #[Route('/with-comments', name: 'articles_with_comments', methods: ['GET'])]
    public function getArticlesWithComments(ArticleRepository $articleRepo): JsonResponse
    {
        $articles = $articleRepo->findAll();

        $result = array_map(function (Article $article) {
            return [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'content' => $article->getContent(),
                'comments' => array_map(fn($comment) => $comment->getContent(), $article->getComments()->toArray()),
            ];
        }, $articles);

        return new JsonResponse(['articles' => $result]);
}


}
