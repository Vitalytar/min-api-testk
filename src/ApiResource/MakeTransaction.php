<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;

#[ApiResource(operations: [
        new Post(name: 'transaction', routeName: 'make_transation'),
    ])]
class MakeTransaction
{
    // TODO: https://fixer.io/ - exchange rates here
}