<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\AccountTransaction;

#[ApiResource(
    operations: [
        new Get(uriTemplate: '/account-transaction/{accountId}'),
        new GetCollection(uriTemplate: '/account-transactions'),
    ],
    provider: AccountTransaction::class
)]
class AccountTransactionsHistory
{}
