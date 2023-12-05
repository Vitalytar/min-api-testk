<?php

namespace App\Tests\Entity;

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
        ClientEntityTest::createClient()->request(method: 'GET', url: 'client/1e');
        $this->assertResponseStatusCodeSame(404);
    }
}
