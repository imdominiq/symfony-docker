<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $article = new Article();
        $article->SetContent('Wlazl kotek na plotek');
        $article->setTitle("To jest nasz pierwszy artykuł!");
        $manager->persist($article);

        $article2 = new Article();
        $article2->setContent("Ala ma kota");
        $article2->setTitle("To jest nasz drugi artykuł!");
        $manager->persist($article2);

        $manager->flush();
    }
}
