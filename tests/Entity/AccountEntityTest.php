<?php

namespace App\Tests\Entity;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class AccountEntityTest
 *
 * @package App\Tests\Entity
 */
final class AccountEntityTest extends ApiTestCase
{
    /**
     * @return void
     * @throws TransportExceptionInterface
     */
    public function testClientDoesNotExist()
    {
        AccountEntityTest::createClient()->request(method: 'GET', url: 'account/1e');
        $this->assertResponseStatusCodeSame(404);
    }
}
