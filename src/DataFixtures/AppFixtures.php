<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\User;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('dominik@example.com');
        $user->setPassword(password_hash('123', PASSWORD_BCRYPT));
        $manager->persist($user);

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
