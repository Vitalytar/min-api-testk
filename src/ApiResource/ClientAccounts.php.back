<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\AccountsRetrieving;

#[ApiResource(
    operations: [
        new Get(uriTemplate: '/client-account/{clientId}'),
        new GetCollection(uriTemplate: '/client-accounts'),
    ],
    provider: AccountsRetrieving::class
)]
class ClientAccounts
{}
