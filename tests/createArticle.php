<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ArticleControllerTest extends WebTestCase
{
    public function testCreateArticleSuccess()
    {
        $client = static::createClient();

        $data = [
            'title' => 'Test Article',
            'content' => 'This is a test article content.',
        ];

        $client->request('POST', '/api/articles', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('Article created', $client->getResponse()->getContent());
    }

    public function testCreateArticleFailureMissingData()
    {
        $client = static::createClient();

        $data = [
            'title' => 'Test Article',
        ];

        $client->request('POST', '/api/articles', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('Invalid data', $client->getResponse()->getContent());
    }
}
