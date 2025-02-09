<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\ArticleProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/artykuly/{id}', name: 'article_show')]
    public function showArticle(
        int $id,
        ArticleRepository $articleRepository,
        ArticleProvider $articleProvider
    ): Response {
        $article = $articleRepository->find($id);

        if (!$article instanceof Article) {
 
            return new Response('Article not found', 404);
        }

        $transformed = $articleProvider->transform([$article]);

        return new Response(
            print_r($transformed, true)
        );
    }

    #[Route('/artykuly', name: 'articles_list')]
    public function listArticles(
        ArticleRepository $articleRepository,
        ArticleProvider $articleProvider
    ): Response {
        $articles = $articleRepository->findAll();

        if (count($articles) === 0) {
            return new Response('No articles found');
        }

        $transformedArticles = $articleProvider->transform($articles);

        return new Response(
            print_r($transformedArticles, true)
        );
    }
}
