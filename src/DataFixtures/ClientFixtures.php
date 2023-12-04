<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Client;
use App\Entity\Account;

/**
 * Class ClientFixtures
 *
 * @package App\DataFixtures
 */
class ClientFixtures extends Fixture
{
    const CLIENT_NAMES = [
        'BigCompany',
        'MediumCompany',
        'SomeonePersonalAccount',
        'DefinedClient1',
        'WindowManager1'
    ];

    const CURRENCIES = [
        'EUR',
        'PLN',
        'AED',
        'GBP'
    ];

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        foreach (self::CLIENT_NAMES as $clientName) {
            $client = new Client();
            $client->setClientName($clientName);
            $manager->persist($client);

            foreach (self::CURRENCIES as $currency) {
                $account = new Account();
                $account->setClient($client);
                $account->setAccountCurrency($currency);
                $account->setAccountName($clientName . $currency);
                $account->setFunds(rand(100000, 10000000));

                if ($clientName === 'SomeonePersonalAccount') {
                    $account->setFunds(1000);
                }

                $manager->persist($account);
            }
        }

        $manager->flush();
    }
}
