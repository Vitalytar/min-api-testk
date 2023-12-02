<?php

declare(strict_types=1);

namespace App\ApiResource;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ApiResource(
    operations: [
        new Get(uriTemplate: '/client-account/{id}'),
        new GetCollection(uriTemplate: '/client-accounts'),
    ])]
class ClientAccounts
{

}
