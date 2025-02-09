<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class BlogControllerTest extends WebTestCase
{
    public function testListArticles()
    {
        $client = static::createClient();

        $client->request('GET', '/artykuly');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('transformed', $client->getResponse()->getContent()); 
    }

    public function testListArticlesNoArticles()
    {
        $client = static::createClient();

        $client->request('GET', '/artykuly');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('No articles found', $client->getResponse()->getContent());
    }
}
