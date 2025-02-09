<?php
declare(strict_types=1);
namespace App\Service;
use App\Entity\Article;

class ArticleProvider{
    public function transform(array $articles): array
    {
        $transformed = [];

        foreach ($articles as $article) {
            $transformed['articles'][] = [
                'title' => $article->getTitle(),
                'content' => substr($article->getContent(), 0, 80) . '...',
                'link' => '/article/' . $article->getId(),
            ];
        }

        return $transformed;
    }
}