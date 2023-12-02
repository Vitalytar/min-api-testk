<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpKernel\Attribute\AsController;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

#[AsController]
class MakeTransaction implements ProviderInterface
{
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $breakpoint = '';
        // TODO: Make here this logic

        return ['Success'];
    }
}
