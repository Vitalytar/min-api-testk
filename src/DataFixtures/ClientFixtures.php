<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Client;

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
        }

        $manager->flush();
    }
}
