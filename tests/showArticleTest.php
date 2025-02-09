<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class BlogControllerTest extends WebTestCase
{
    public function testShowArticle()
    {
        $client = static::createClient();

        $client->request('GET', '/artykuly/1');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('transformed', $client->getResponse()->getContent());
    }

    public function testShowArticleNotFound()
    {
        $client = static::createClient();

        $client->request('GET', '/artykuly/9999');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Article not found', $client->getResponse()->getContent());
    }
}
