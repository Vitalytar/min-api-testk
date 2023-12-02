<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\MakeTransaction as MakeTransactionController;

#[ApiResource(
    operations: [new Post(uriTemplate: '/make-transaction', name: 'make_transaction')],
    provider: MakeTransactionController::class
)]
class MakeTransaction
{
    // TODO: https://fixer.io/ - exchange rates here
}
