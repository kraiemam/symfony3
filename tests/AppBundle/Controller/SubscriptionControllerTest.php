<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;


class SubscriptionControllerTest extends WebTestCase
{

    public function testViewSubscriptionAction()
    {
        // Create a new client to browse the application
        $client = static::createClient();
        $client->request('GET', '/subscription/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    public function testCreateAction()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/subscription',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"contact_id": 1,"product_id":1,"begin_date": "2020-03-16T00:00:00+01:00","end_date": "2020-03-31T00:00:00+01:00"}'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
    public function testUpdateAction()
    {
        $client = static::createClient();
        $client->request(
            'PUT',
            '/subscription/3',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"contact_id": 2,"product_id":1,"begin_date": "2020-03-16T00:00:00+01:00","end_date": "2020-03-31T00:00:00+01:00"}'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteAction()
    {
        $client = static::createClient();
        $client->request(
            'DELETE',
            '/subscription/12'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
