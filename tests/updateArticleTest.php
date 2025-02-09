<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ArticleControllerTest extends WebTestCase
{
    public function testUpdateArticleSuccess()
    {
        $client = static::createClient();

        $data = [
            'title' => 'Updated Test Article',
            'content' => 'Updated content of the test article.',
        ];

        $client->request('PUT', '/api/articles/1', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('Article updated', $client->getResponse()->getContent());
    }

    public function testUpdateArticleNotFound()
    {
        $client = static::createClient();

        $data = [
            'title' => 'Non-existent Article',
            'content' => 'This article does not exist.',
        ];

        $client->request('PUT', '/api/articles/9999', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('Article not found', $client->getResponse()->getContent());
    }
}
