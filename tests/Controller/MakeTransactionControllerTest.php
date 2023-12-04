<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use App\Entity\Account;

/**
 * Class MakeTransactionControllerTest
 *
 * @package App\Tests\Controller
 */
class MakeTransactionControllerTest extends WebTestCase
{
    public function setUp(): void
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->setAutoExit(false);

        // Load fixtures
        $input = new StringInput('doctrine:fixtures:load --no-interaction');
        $application->run($input);
    }

    public function testMakeTransactionFailure()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/make/transaction',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'senderAccountId' => 5,
                'receiverAccountId' => 6,
                // Missing amount param
                'currency' => 'EUR',
            ])
        );

        $this->assertEquals(500, $client->getResponse()->getStatusCode());

        $client->request(
            'POST',
            '/make/transaction',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'senderAccountId' => 5,
                'receiverAccountId' => 6,
                'amount' => 10,
                'currency' => '1EUR1',
            ])
        );

        $this->assertEquals(500, $client->getResponse()->getStatusCode());

        $client->request(
            'POST',
            '/make/transaction',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'senderAccountId' => 19248923850823578293598235,
                'receiverAccountId' => 2935804386834623532,
                'amount' => 10,
                'currency' => 'EUR',
            ])
        );

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertEquals(['error' => true, 'message' => 'One of the accounts was not found!'], json_decode($client->getResponse()->getContent(), true));
    }

    public function testSuccessfulTransaction()
    {
        $client = static::createClient();

        $repository = $client->getContainer()->get('doctrine')->getRepository(Account::class);
        $senderAccount = $repository->findOneBy(['account_name' => 'BigCompanyEUR']);
        $receiverAccount = $repository->findOneBy(['account_name' => 'MediumCompanyEUR']);

        $client->request(
            'POST',
            '/make/transaction',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'senderAccountId' => $senderAccount->getId(),
                'receiverAccountId' => $receiverAccount->getId(),
                'amount' => 10,
                'currency' => 'EUR',
            ])
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertEquals(['error' => false, 'message' => 'Transaction successful'], json_decode($client->getResponse()->getContent(), true));

        $client->request(
            'POST',
            '/make/transaction',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'senderAccountId' => $senderAccount->getId(),
                'receiverAccountId' => $receiverAccount->getId(),
                'amount' => $senderAccount->getFunds() + 100000,
                'currency' => 'EUR',
            ])
        );

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertEquals(['error' => true, 'message' => 'Not enough funds on sender account'], json_decode($client->getResponse()->getContent(), true));

        $client->request(
            'POST',
            '/make/transaction',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'senderAccountId' => $senderAccount->getId(),
                'receiverAccountId' => $receiverAccount->getId(),
                'amount' => $senderAccount->getFunds(),
                'currency' => 'AED',
            ])
        );

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertEquals(['error' => true, 'message' => 'Receiver account currency is different'], json_decode($client->getResponse()->getContent(), true));
    }
}
