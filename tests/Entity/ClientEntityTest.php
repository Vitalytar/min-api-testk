<?php

namespace App\Tests\Entity;

use App\Entity\Client;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class ClientEntityTest
 *
 * @package App\Tests\Entity
 */
final class ClientEntityTest extends ApiTestCase
{
    /**
     * @return void
     * @throws TransportExceptionInterface
     */
    public function testClientDoesNotExist()
    {
        ClientEntityTest::createClient()->request(method: 'GET', url: 'api/client/1e');
        $this->assertResponseStatusCodeSame(404);
        $this->assertJsonContains([
            'detail' => 'Not Found',
        ]);
    }

    /**
     * @return void
     * @throws TransportExceptionInterface
     */
    public function testAccountExist()
    {
        $client = AccountEntityTest::createClient();

        $repository = $client->getContainer()->get('doctrine')->getRepository(Client::class);
        $senderAccount = $repository->findOneBy(['client_name' => 'BigCompany']);
        $accountId = $senderAccount->getId();

        $client->request(method: 'GET', url: "api/client/$accountId");
        $this->assertResponseStatusCodeSame(200);
    }
}
