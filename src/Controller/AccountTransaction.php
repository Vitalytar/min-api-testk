<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpKernel\Attribute\AsController;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

#[AsController]
class AccountTransaction implements ProviderInterface
{
    /**
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     *
     * @return object|array|object[]|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $breakpoint = [];

        echo $uriVariables['id'];
        return ['test'];
    }
}
