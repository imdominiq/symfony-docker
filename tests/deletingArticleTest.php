<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ArticleControllerTest extends WebTestCase
{
    public function testDeleteArticleSuccess()
    {
        $client = static::createClient();

        $client->request('DELETE', '/api/articles/1');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('Article deleted', $client->getResponse()->getContent());
    }

    public function testDeleteArticleNotFound()
    {
        $client = static::createClient();

        $client->request('DELETE', '/api/articles/9999');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('Article not found', $client->getResponse()->getContent());
    }
}
