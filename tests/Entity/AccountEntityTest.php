<?php

namespace App\Tests\Entity;

use App\Entity\Account;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class AccountEntityTest
 *
 * @package App\Tests\Entity
 */
final class AccountEntityTest extends ApiTestCase
{
    public function setUp(): void
    {
        $kernel = AccountEntityTest::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->setAutoExit(false);

        // Load fixtures
        $input = new StringInput('doctrine:fixtures:load --no-interaction');
        $application->run($input);
    }

    /**
     * @return void
     * @throws TransportExceptionInterface
     */
    public function testAccountDoesNotExist()
    {
        AccountEntityTest::createClient()->request(method: 'GET', url: 'api/account/1e');
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

        $repository = $client->getContainer()->get('doctrine')->getRepository(Account::class);
        $senderAccount = $repository->findOneBy(['account_name' => 'BigCompanyEUR']);
        $accountId = $senderAccount->getId();

        $client->request(method: 'GET', url: "api/account/$accountId");
        $this->assertResponseStatusCodeSame(200);
    }
}
