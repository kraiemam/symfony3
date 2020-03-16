<?php

namespace AppBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use AppBundle\DataFixtures\ORM\LoadTestData;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Input\ArrayInput;
use Doctrine\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\Proxy\CreateSchemaDoctrineCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Console\Tester\CommandTester;

class SubscriptionControllerTest extends WebTestCase
{

    private $application;

    public function setUp() {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->application = new Application(static::$kernel);

        // drop the database
        $command = new DropDatabaseDoctrineCommand();
        $this->application->add($command);
        $input = new ArrayInput(array(
            'command' => 'doctrine:database:drop',
            '--force' => true
        ));
        $command->run($input, new NullOutput());

        // we have to close the connection after dropping the database so we don't get "No database selected" error
        $connection = $this->application->getKernel()->getContainer()->get('doctrine')->getConnection();
        if ($connection->isConnected()) {
            $connection->close();
        }

        // create the database
        $command = new CreateDatabaseDoctrineCommand();
        $this->application->add($command);
        $input = new ArrayInput(array(
            'command' => 'doctrine:database:create',
        ));
        $command->run($input, new NullOutput());

        // create schema
        $command = new CreateSchemaDoctrineCommand();
        $this->application->add($command);
        $input = new ArrayInput(array(
            'command' => 'doctrine:schema:create',
        ));
        $command->run($input, new NullOutput());


        $client = static::createClient();
        $container = $client->getContainer();
        $doctrine = $container->get('doctrine');
        $entityManager = $doctrine->getManager();

        $fixture = new LoadTestData();
        $fixture->load($entityManager);
    }

    public function testViewSubscriptionAction()
    {
        // Create a new client to browse the application
        $client = static::createClient();
        $client->request('GET', '/subscription/1');

        $response = $client->getResponse();

        // Test if response is OK
        $this->assertSame(200, $client->getResponse()->getStatusCode(),'Unexpected status code response ');
        // Test if Content-Type is valid application/json
        $this->assertSame('application/json', $response->headers->get('Content-Type'),'Unexpected content type response');
        // Test response content fetch json format and test data
        $this->assertJsonStringEqualsJsonString($client->getResponse()->getContent(),
            '[{
        "id": 1,
        "contact": {
            "id": 2,
            "name": "david",
            "firstname": "david"
        },
        "product": {
            "id": 1,
            "label": "smartphone"
        },
        "begin_date": "2020-03-15T00:00:00+01:00",
        "end_date": "2020-03-17T00:00:00+01:00"
    }]',
            'Unexpected Json response');
    }



    public function testCreateAction()
    {
        // Create a new client to browse the application
        $client = static::createClient();
        $client->request(
            'POST',
            '/subscription',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{
                "contact": {
                    "id":1,
                    "name": "david1",
                    "firstname": "david1"
                },
                "product": {
                    "id":1,
                    "label": "smartphone1"
                },
                "begin_date": "2020-03-16T00:00:00+01:00",
                "end_date": "2020-03-17T00:00:00+01:00"
            }'
        );

        $response = $client->getResponse();
        // Test if response is OK
        $this->assertSame(201, $client->getResponse()->getStatusCode(),'Unexpected status code response ');
    }

    public function testDeleteAction()
    {
        // Create a new client to browse the application
        $client = static::createClient();
        $client->request('DELETE', '/subscription/5');

        // Test if response is OK
        $this->assertSame(204, $client->getResponse()->getStatusCode(),'Unexpected status code response ');
    }

    
}
